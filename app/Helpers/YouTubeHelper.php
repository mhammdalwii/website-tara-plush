<?php

namespace App\Helpers;

class YouTubeHelper
{
    /**
     * Mengubah URL YouTube biasa menjadi URL embed.
     *
     * @param string|null $url
     * @return string|null
     */
    public static function getEmbedUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        // Regex untuk mencari ID video dari berbagai format URL YouTube
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        if (preg_match($pattern, $url, $matches)) {
            // Jika ID ditemukan, buat URL embed yang benar
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Jika sudah dalam format embed atau bukan link YouTube, kembalikan apa adanya
        return $url;
    }
}
