<?php
session_start();
function display_offline_mode( $part ){
	$num = array(); 
	$num[0] = "๐";
	$num[1] = "๑";
	$num[2] = "๒";
	$num[3] = "๓";
	$num[4] = "๔";
	$num[5] = "๕";
	$num[6] = "๖";
	$num[7] = "๗";
	$num[8] = "๘";
	$num[9] = "๙";
	
	srand(make_seed());
	$mode = rand(1, 3);
	$first_num;
	$second_num;
	$ans_num;
	$op;
	if( $mode == 1 ){
		$first_num = rand( 1, 99);
		$second_num = rand( 1, 99);
		$ans_num = $first_num + $second_num;
		$op = "บวก";
	}else if( $mode == 2 ){
		$first_num = rand( 1, 99);
		$second_num = rand( 1, 99);
		if( $first_num < $second_num ){
			$temp_num = $first_num;
			$first_num = $second_num;
			$second_num = $temp_num;	
		}
		$ans_num = $first_num - $second_num;
		$op = "ลบ";
	}else if( $mode == 3 ){
		$first_num = rand( 1, 9);
		$second_num = rand( 1, 9);
		$ans_num = $first_num * $second_num;
		$op = "คูณ";
	}
	
	$str = "";
	if ( $first_num >= 10 ){
		$str .= $num[ $first_num / 10 ];
	}
	$str .= $num[ $first_num % 10 ];
	
	$str .= " $op ";
	
	if ( $second_num >= 10 ){
		$str .= $num[ $second_num / 10 ];
	}
	$str .= $num[ $second_num % 10 ];
	$_SESSION["capth_str"] = $str;
	
	$randnum = rand(0, 1000);
	
	global $options;
    global $capth_def_setting;
    $url = plugins_url('captcha-in-thai/image.php');
    $url .= "?font_size={$capth_def_setting['font_size']}";
    $url .= "&width={$capth_def_setting['width']}";
    $url .= "&height={$capth_def_setting['height']}";
    
    if( "login" == $part ){
        $url .= "&font_color=".substr($options['login_font_color'], 1);
        $url .= "&bg_color=".substr($options['login_bg_color'], 1);
    }else if( "register" == $part ){
        $url .= "&font_color=".substr($options['register_font_color'], 1);
        $url .= "&bg_color=".substr($options['register_bg_color'], 1);
    }else if( "comment" == $part ){
        $url .= "&font_color=".substr($options['comment_font_color'], 1);
        $url .= "&bg_color=".substr($options['comment_bg_color'], 1);
    }else if( "lostpassword" == $part ){
		$url .= "&font_color=".substr($options['lostpassword_font_color'], 1);
        $url .= "&bg_color=".substr($options['lostpassword_bg_color'], 1);
	}
	
	
	$url .= "&noise={$options['noise']}";
	$url .= "&distorted={$options['distorted']}";

	echo "<br />";
	
	$info = "หาค่าต่อไปนี้<br />&nbsp;เช่น ๑ บวก ๑ ให้ตอบ ๒ หรือตอบ 2";

	
?>
	<table cellpadding="0" cellspacing="0" width="250" rules="all" border="1" style="border: solid; border-color: #00AfAf;" >
        <tr>
            <td bgcolor="#f5fffa"><font color="2f4f4f"><b><center><?= $info ?></center></b></font></td>
        </tr>
        <tr>
            <td bgcolor="#00AfAf" valign=""><img src="<?= $url."&debug=$randnum" ?>" /></td>
        </tr>
        <tr>
        	<td width="250-30" bgcolor="pink" align="center"><b><center>แคปชาในภาษาไทย</center></b></td>
        </tr>
	</table>
	<input type="text" name="answer" id="answer"  />
	<input type='hidden' name='ans_num' id="ans_num" value="<?=$ans_num?>" />
	
<?php
	
}

function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

?>
