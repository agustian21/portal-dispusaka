<?php

namespace Tests\Unit;

use App\Support\GoogleDriveLink;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GoogleDriveLinkTest extends TestCase
{
    #[DataProvider('validLinks')]
    public function test_it_normalizes_supported_file_links(string $input, string $id, string $suffix = ''): void
    {
        $this->assertSame([
            'preview' => 'https://drive.google.com/file/d/'.$id.'/preview'.$suffix,
            'open' => 'https://drive.google.com/file/d/'.$id.'/view'.$suffix,
        ], GoogleDriveLink::from($input));
    }

    public static function validLinks(): array
    {
        return [
            'drive share' => ['https://drive.google.com/file/d/abc_123-XYZ/view?usp=sharing', 'abc_123-XYZ'],
            'drive preview' => ['https://drive.google.com/file/d/abc_123-XYZ/preview', 'abc_123-XYZ'],
            'open' => ['https://drive.google.com/open?id=abc_123-XYZ', 'abc_123-XYZ'],
            'download link' => ['https://drive.google.com/uc?export=download&id=abc_123-XYZ', 'abc_123-XYZ'],
            'resource key' => ['https://drive.google.com/file/d/abc_123-XYZ/view?resourcekey=0-secret_Key&usp=sharing', 'abc_123-XYZ', '?resourcekey=0-secret_Key'],
            'document' => ['https://docs.google.com/document/d/abc_123-XYZ/edit?usp=sharing', 'abc_123-XYZ'],
            'sheet' => ['https://docs.google.com/spreadsheets/d/abc_123-XYZ/edit#gid=0', 'abc_123-XYZ'],
            'slides' => ['https://docs.google.com/presentation/d/abc_123-XYZ/edit', 'abc_123-XYZ'],
            'account prefix' => ['https://drive.google.com/file/u/0/d/abc_123-XYZ/view', 'abc_123-XYZ'],
            'doc account prefix' => ['https://docs.google.com/document/u/0/d/abc_123-XYZ/edit', 'abc_123-XYZ'],
            'trim' => ['  https://drive.google.com/file/d/abc_123-XYZ/view  ', 'abc_123-XYZ'],
        ];
    }

    #[DataProvider('invalidLinks')]
    public function test_it_rejects_untrusted_or_unsupported_links(?string $input): void
    {
        $this->assertNull(GoogleDriveLink::from($input));
    }

    public static function invalidLinks(): array
    {
        return [
            [null], [''], ['   '], ['abc_123-XYZ'],
            ['javascript:alert(1)'], ['data:text/html,<script>alert(1)</script>'],
            ['http://drive.google.com/file/d/abc/view'],
            ['https://evil.example/file/d/abc/view'],
            ['https://drive.google.com.evil.example/file/d/abc/view'],
            ['https://drive.google.com@evil.example/file/d/abc/view'],
            ['https://user@drive.google.com/file/d/abc/view'],
            ['https://user:pass@drive.google.com/file/d/abc/view'],
            ['https://drive.google.com:8443/file/d/abc/view'],
            ['https://drive.google.com/drive/folders/abc'],
            ['https://drive.google.com/open?id[]=abc'],
            ['https://drive.google.com/open?id=%3Cscript%3E'],
            ['https://drive.google.com/file/d/abc/unsupported'],
            ['https://docs.google.com/document/d/e/published-id/pub'],
            ["https://drive.google.com/\nfile/d/abc/view"],
            ['<iframe src="https://drive.google.com/file/d/abc/preview"></iframe>'],
        ];
    }
}
