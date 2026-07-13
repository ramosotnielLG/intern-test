<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class ArticleDocxController extends Controller
{
    public function convert(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:docx|max:10240', // max 10MB
        ]);

        $file = $request->file('file');
        $tempPath = $file->getRealPath();

        try {
            $phpWord = IOFactory::load($tempPath, 'Word2007');

            Settings::setOutputEscapingEnabled(true);
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

            $tempHtmlPath = tempnam(sys_get_temp_dir(), 'docx_html_') . '.html';
            $htmlWriter->save($tempHtmlPath);
            $fullHtml = file_get_contents($tempHtmlPath);
            unlink($tempHtmlPath);

            $bodyContent = $this->extractBody($fullHtml);

            return response()->json([
                'success' => true,
                'html' => $bodyContent,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file Word: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Ambil isi <body> dari HTML hasil PHPWord menggunakan DOMDocument,
     * dan buang elemen <style>/<script> yang ikut terbawa di dalam body
     * (PHPWord kadang menaruh sebagian style di awal body juga).
     */
    private function extractBody(string $html): string
    {
        // Suppress warning dari malformed HTML (PHPWord output kadang tidak 100% valid)
        $previousSetting = libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        // loadHTML butuh encoding declaration agar karakter non-ASCII tidak rusak
        $dom->loadHTML(
            '<?xml encoding="UTF-8">' . $html,
            LIBXML_NOWARNING | LIBXML_NOERROR
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousSetting);

        $body = $dom->getElementsByTagName('body')->item(0);

        if (!$body) {
            // Fallback: kalau body benar-benar tidak ketemu, kembalikan html asli
            // supaya tidak silent-fail, tapi ini seharusnya jarang terjadi dengan DOMDocument
            return $html;
        }

        // Buang semua <style> dan <script> yang ada di DALAM body
        // (PHPWord biasanya taruh <style> di <head>, tapi kita jaga-jaga)
        $this->stripTags($body, ['style', 'script']);

        // Ambil innerHTML dari <body>
        $innerHtml = '';
        foreach ($body->childNodes as $child) {
            $innerHtml .= $dom->saveHTML($child);
        }

        return trim($innerHtml);
    }

    private function stripTags(\DOMElement $element, array $tagNames): void
    {
        foreach ($tagNames as $tagName) {
            $nodes = $element->getElementsByTagName($tagName);
            // Hapus dari belakang ke depan karena NodeList live-updates saat dihapus
            for ($i = $nodes->length - 1; $i >= 0; $i--) {
                $node = $nodes->item($i);
                $node->parentNode->removeChild($node);
            }
        }
    }
}