<?php

return [
  'headers' => [
      'col_types' => [
        1 => 'テキスト',
        2 => 'メンバー',
        3 => '日付',
        4 => '選択',
    ],

      'defaults' => [
          [
              'col_type' => 1,
              'col_name' => 'テスト項目'
          ],
          [
              'col_type' => 4,
              'col_name' => '正常/異常'
          ],
          [
              'col_type' => 1,
              'col_name' => 'テスト条件'
          ],
          [
              'col_type' => 1,
              'col_name' => '確認方法'
          ],
          [
              'col_type' => 1,
              'col_name' => '備考'
          ],
          [
              'col_type' => 3,
              'col_name' => '実施日'
          ],
          [
              'col_type' => 2,
              'col_name' => '実施者'
          ],
          [
              'col_type' => 0,
              'col_name' => '結果'
          ],
      ],

  ],
];
