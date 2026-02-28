<?php

return [
    'required' => ':attributeを入力してください',

    'min' => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],

    'max' => [
        'string' => ':attributeは:max文字以内で入力してください',
    ],

    'regex' => ':attributeの形式が正しくありません',

    'confirmed' => ':attributeが一致しません',

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => '確認用パスワード',
        'profile_image' => 'プロフィール画像',
        'username' => 'ユーザー名',
        'postcode' => '郵便番号',
        'address' => '住所',
        'building' => '建物名',
    ],
];
