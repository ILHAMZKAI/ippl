<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>

<body>
    <table
        style="width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; color:rgb(46, 46, 46); border-collapse: collapse;">
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #2bc842;">
                <h2>Welcome to GoEstate</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: left;">
                <p>Hello!</p>
                <p>Terima kasih telah bergabung dengan GoEstate. Kami sangat senang Anda bergabung sebagai bagian dari
                    kami.</p>
                <p>Klik tombol dibawah untuk memverifikasi email anda!</p>
            </td>
            @isset($actionText)
            <?php
                $color = match ($level) {
                    'success', 'error' => $level,
                    default => 'success',
                };
                ?>
            <x-mail::button :url="$actionUrl" :color="$color">
                {{ $actionText }}
            </x-mail::button>
            @endisset
        </tr>
        @isset($actionText)
        @lang('Klik link dibawah jika tombol diatas tidak berfungsi:')<br>
        <a href="{{ $actionUrl }}"
            style="display: inline-block; padding: 10px; color: rgb(87, 156, 252); text-decoration: none;">{{
            $displayableActionUrl }}</a>
        @endisset
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #2bc842;">
                <p>&copy; 2023 GoEstate. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>

</html>