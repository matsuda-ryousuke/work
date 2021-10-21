<?php

/* ==========================================
  入力された数値S、単語群A(i,j)をもとに、
  ビンゴカード、$bingo_arr を生成する。
========================================== */

fscanf(STDIN, "%d", $s); // サイズS*S の読み込み

$bingo_arr = []; // $bingo_arr = ビンゴカード

// S列の入力文字列を読み込み、$bingo_arrに格納して二次元配列のビンゴカードを作成
for ($i = 0; $i < $s; $i++) {
  $line = trim(fgets(STDIN));
  $line = str_replace(["\r\n", "\r", "\n"], "", $line);
  $line = explode(" ", $line); // $line = ビンゴ横一行の配列
  array_push($bingo_arr, $line);
}

/* ==========================================
  $bingo_arr と同じサイズで、
  印の箇所を管理するための配列、$marked_arr を生成。
  読み込んだ単語w(i)が$bingo_arr 上に存在するかを判定し、$marked_arrに印を付ける。
========================================== */

// $marked_arr = 印の箇所を管理する為の二次元配列。サイズS*S、要素が全て0、印が付いた箇所を1にする
$marked_arr = array_fill(0, $s, array_fill(0, $s, 0));

fscanf(STDIN, "%d", $n); // 単語数N の読み込み

// N個の単語を読み込み、$marked_arr に印をつけるループ
for ($i = 0; $i < $n; $i++) {
  fscanf(STDIN, "%s", $word); // 単語読み込み

  // ビンゴカード上から一行ずつ、単語があるかチェックするループ
  for ($j = 0; $j < $s; $j++) {
    // $bingo_arr の $j行目に、対象の単語が存在するかチェック
    $search_result = array_search($word, $bingo_arr[$j]);
    // 単語を見つけたら、$marked_arr の同じ箇所を 1 に変更
    if ($search_result !== false) {
      $marked_arr[$j][$search_result] = 1;
      break; // ビンゴカード内に同一単語はないため、見つけた時点で次の単語へ
    }
  }
}

/* ==========================================
  $marked_arr に対し、ビンゴの判定を行う。
  縦、横、斜めの各ラインに対し、印が付いていない = 0 の要素が
  ひとつでもあるかを判定する。
========================================== */

$lr_flag = 1; // 左斜め上～右斜め下のライン上のビンゴ判定フラグ
$ll_flag = 1; // 右斜め上～左斜め下のライン上のビンゴ判定フラグ

// $marked_arr 内の各列を確認するループ
for ($i = 0; $i < $s; $i++) {
  $v_flag = 1; // 横 $i行目のビンゴ判定フラグ初期化
  $h_flag = 1; // 縦 $i列目のビンゴ判定フラグ初期化

  // $marked_arr の $i 列目の各要素の印を確認するループ
  for ($j = 0; $j < $s; $j++) {
    // 横一行、縦一列の各要素をチェック、印なしの要素を見つけたら、フラグを0にする
    if ($marked_arr[$i][$j] == 0) {
      $v_flag = 0;
    }
    if ($marked_arr[$j][$i] == 0) {
      $h_flag = 0;
    }
    // 横と縦、どちらもビンゴがないことが確認できたら、内部ループを抜けて次の列へ
    if ($v_flag == 0 && $h_flag == 0) {
      break;
    }
  }
  // 横、縦のビンゴを1ライン = ループ 毎に判定
  if ($v_flag == 1 || $h_flag == 1) {
    break; // ビンゴを見つけた時点でループを抜ける
  }

  // 斜め列をチェック
  if ($marked_arr[$i][$i] == 0) {
    $lr_flag = 0;
  }
  if ($marked_arr[$i][$s - 1 - $i] == 0) {
    $ll_flag = 0;
  }
}

// ビンゴ判定に基づいて出力
if ($v_flag == 1 || $h_flag == 1 || $lr_flag == 1 || $ll_flag == 1) {
  echo "yes";
} else {
  echo "no";
}