<?php
function download_image($url, $name)
{
    $path = ASSETS . "/$name.jpeg";
    if (!file_exists($path)) {
        dbg([
            'url' => $url,
            'path' => $path,
        ], "Downloading image");
        download($url, $path);
        jpegify($path);
    }
    return $path;
}

function jpegify($file)
{
    $w = 1024;
    $h = 1024;
    // https://stackoverflow.com/a/7262050
    // https://legacy.imagemagick.org/Usage/resize/#shrink
    `convert -strip -resize {$w}x{$h}\> -interlace Plane -gaussian-blur 0.05 -quality 85% "$file" "$file"`;
}

// from chatgpt
function image_format($imagePath)
{
    // Get image information
    $imageInfo = getimagesize($imagePath);

    if ($imageInfo !== false) {
        // Image format is in index 2
        $imageType = $imageInfo[2];

        switch ($imageType) {
            case IMAGETYPE_GIF:
                echo "This is a GIF image.";
                break;
            case IMAGETYPE_JPEG:
                echo "This is a JPEG image.";
                break;
            case IMAGETYPE_PNG:
                echo "This is a PNG image.";
                break;
            case IMAGETYPE_BMP:
                echo "This is a BMP image.";
                break;
            case IMAGETYPE_WEBP:
                echo "This is a WEBP image.";
                break;
            case IMAGETYPE_TIFF_II:
            case IMAGETYPE_TIFF_MM:
                echo "This is a TIFF image.";
                break;
            default:
                echo "Unknown image format.";
                break;
        }
    } else {
        echo "The file is not a valid image.";
    }
}
