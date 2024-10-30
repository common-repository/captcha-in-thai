<?php
function menu_page()
{
    global $options;
    global $capth_def_setting;
    
    if( isset( $_REQUEST['cptch_form_submit'] ))
    {
        if( 'no' == $_REQUEST['question_type1'] && 'no' == $_REQUEST['question_type2'] && 'no' == $_REQUEST['question_type3'] ){
            $err = "การบันทึกล้มเหลว<br />กรุณาเลือกชนิดคำถามอย่างน้อย 1 ชนิด และทำการบันทึกใหม่อีกครั้ง";
        }else{
            foreach ($options as $key => $value) {
                $options[$key] = $_REQUEST[$key];
            }
            //$options = array_merge( $options, $request_options );
            update_option( 'capth_options', $options, '', 'yes' );
        }
    }
?>
<script type="text/javascript">
    <!--    
        function showimage( ele )
        {
            url = "<?= plugins_url("captcha-in-thai/image.php")  ?>";
            url += "?font_size=" + "<?= $capth_def_setting['font_size'] ?>";
            url += "&width=" + "<?= $capth_def_setting['width'] ?>";
            url += "&height=" + "<?= $capth_def_setting['height'] ?>";
            if( ele == "login_show" ){
                fontcol = document.getElementById('login_font_color').value;
                bgcol = document.getElementById('login_bg_color').value;
            }else if( ele == "register_show" ){
                fontcol = document.getElementById('register_font_color').value;
                bgcol = document.getElementById('register_bg_color').value;
            }else if( ele == "comment_show" ){
                fontcol = document.getElementById('comment_font_color').value;
                bgcol = document.getElementById('comment_bg_color').value;
            }else if( ele == "lostpassword_show" ){
                fontcol = document.getElementById('lostpassword_font_color').value;
                bgcol = document.getElementById('lostpassword_bg_color').value;
            }
            url += "&font_color=" + fontcol.substr( 1 );
            url += "&bg_color=" + bgcol.substr( 1 );
            url += "&show_in_setting=1";
            url += "&distorted='yes'";
            url += "&str=<?=urlencode( stripslashes("ทดสอบ"))?>";
            
            var noise = document.getElementsByName('noise');
            for ( i=0 ; i<4 ; i++ ){
                if ( noise[i].checked == true ){
                    url += "&noise="+noise[i].value;
                } 
            }
            
            var distorted = document.getElementsByName('distorted');
            for ( i=0 ; i<4 ; i++ ){
                if ( distorted[i].checked == true ){
                    url += "&distorted="+distorted[i].value;
                }
            }

            document.getElementById(ele).innerHTML = '<iframe src="'+url+'" style="border:none" width="350" scrolling="no"></iframe>';
        }
        
        function show_all( ){
            showimage( 'login_show' );
            showimage( 'register_show' );
            showimage( 'comment_show' );
        }
    //-->
</script>
<script type="text/javascript" src=<?=plugins_url("captcha-in-thai/jscolor/jscolor.js")?>></script>
<br />
<div style="font-size: 26px">แคปชาในภาษาไทย</div>
<br />
<form method="post" action="admin.php?page=capthsetting">
    <table>
        
        <tr><td colspan="4"><span style="color: red"><? if( isset($err) ) echo $err ?></span></td></tr>
        <tr>
            <td colspan="4" align="center"><input type="submit" value="Save" /></td>
        </tr>
        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <th width="150" align="left"><h2><font color="blue">ประเภทคำถาม</font></h2></th>
            <td width="300"></td>
            <td width="150"></td>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">คำที่มักเขียนผิด</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="question_type1" value="yes" <?= ( 'yes' == $options['question_type1'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="question_type1" value="no" <?= ( 'no' == $options['question_type1'] ) ? "checked='checked'" : NULL ?> /></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">คำอ่าน</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="question_type2" value="yes" <?= ( 'yes' == $options['question_type2'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="question_type2" value="no" <?= ( 'no' == $options['question_type2'] ) ? "checked='checked'" : NULL ?> /></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สุภาษิต</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="question_type3" value="yes" <?= ( 'yes' == $options['question_type3'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="question_type3" value="no" <?= ( 'no' == $options['question_type3'] ) ? "checked='checked'" : NULL ?> /></td>
        </tr>
        
        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp</td></tr>

        <tr>
            <th width="150" align="left" ><h2><font color="blue">การแสดงผล</font></h2></th>
            <td width="300"></td>
            <td width="150"></td>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">การบิดเบี้ยวของตัวอักษร</th>
            <td colspan="2">มาก  &nbsp;&nbsp;<input type="radio" onclick="show_all()" name="distorted" value="high" <?= ( 'high' == $options['distorted'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;
                                         กลาง &nbsp;&nbsp;<input type="radio" onclick="show_all()" name="distorted" value="med" <?= ( 'med' == $options['distorted'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;
                                         น้อย  &nbsp;&nbsp;<input type="radio" onclick="show_all()" name="distorted" value="low" <?= ( 'low' == $options['distorted'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;
                                         ปิด&nbsp;&nbsp;<input type="radio" onclick="show_all()" name="distorted" value="no" <?= ( 'no' == $options['distorted'] ) ? "checked='checked'" : NULL ?> /></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">เส้นและจุด</th>
            <td colspan="2">มาก  &nbsp;&nbsp;<input type="radio" onclick="show_all()" name="noise" value="high" <?= ( 'high' == $options['noise'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;
                                           กลาง  &nbsp;&nbsp;<input type="radio" onclick="show_all()" name="noise" value="med" <?= ( 'med' == $options['noise'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;                           
                                           น้อย  &nbsp;&nbsp;<input type="radio" onclick="show_all()" name="noise" value="low" <?= ( 'low' == $options['noise'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;                           
                                           ปิด&nbsp;&nbsp;<input type="radio" onclick="show_all()" name="noise" value="no" <?= ( 'no' == $options['noise'] ) ? "checked='checked'" : NULL ?> /></td>
        </tr>
        
        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp</td></tr>
        
        <tr>
            <th width="150" align="left" ><h2><font color="blue">Login</font></h2></th>
            <td width="300"></td>
            <td width="150"></td>
            <td></td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td></td>
            <th align="left">เปิดใช้งานหน้า Login</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="captcha_login" value="yes" <?= ( 'yes' == $options['captcha_login'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="captcha_login" value="no" <?= ( 'no' == $options['captcha_login'] ) ? "checked='checked'" : NULL ?> /></td>
            <td rowspan="3"><b>ตัวอย่าง</b><div id="login_show"></div></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีตัวอักษร</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="login_font_color" id="login_font_color" onchange="showimage('login_show')" value=<?=$options['login_font_color']?>><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีพื้นหลัง</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="login_bg_color" id="login_bg_color" onchange="showimage('login_show')" value=<?=$options['login_bg_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp</td></tr>
        
        <tr>
            <th width="150" align="left" ><h2><font color="blue">Register</font></h2></th>
            <td width="300"></td>
            <td width="150"></td>
            <td></td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td></td>
            <th align="left">เปิดใช้งานหน้า Register</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="captcha_register" value="yes" <?= ( 'yes' == $options['captcha_register'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="captcha_register" value="no" <?= ( 'no' == $options['captcha_register'] ) ? "checked='checked'" : NULL ?> /></td>
            <td rowspan="3"><b>ตัวอย่าง</b><div id="register_show"></div></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีตัวอักษร</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="register_font_color" id="register_font_color" onchange="showimage('register_show')" value=<?=$options['register_font_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีพื้นหลัง</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="register_bg_color" id="register_bg_color" onchange="showimage('register_show')" value=<?=$options['register_bg_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp</td></tr>
        
        <tr>
            <th width="150" align="left" ><h2><font color="blue">Comment</font></h2></th>
            <td width="300"></td>
            <td width="150"></td>
            <td></td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td></td>
            <th align="left">เปิดใช้งานหน้า Comment</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="captcha_comments" value="yes" <?= ( 'yes' == $options['captcha_comments'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="captcha_comments" value="no" <?= ( 'no' == $options['captcha_comments'] ) ? "checked='checked'" : NULL ?> /></td>
            <td rowspan="3"><b>ตัวอย่าง</b><div id="comment_show"></div></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีตัวอักษร</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="comment_font_color" id="comment_font_color" onchange="showimage('comment_show')" value=<?=$options['comment_font_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีพื้นหลัง</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="comment_bg_color" id="comment_bg_color" onchange="showimage('comment_show')" value=<?=$options['comment_bg_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">ซ่อน CAPTCHA กับผู้ที่เข้าสู่ระบบแล้ว</th>
            <td>ใช่  &nbsp;&nbsp;<input type="radio" name="hide_register_user" value="yes" <?= ( 'yes' == $options['hide_register_user'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input type="radio" name="hide_register_user" value="no" <?= ( 'no' == $options['hide_register_user'] ) ? "checked='checked'" : NULL ?> /></td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>

        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp</td></tr>
        <tr>
            <th width="150" align="left" ><h2><font color="blue">Lost Password</font></h2></th>
            <td width="300"></td>
            <td width="150"></td>
            <td></td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td></td>
            <th align="left">เปิดใช้งานหน้า Lost Password</th>
            <td>เปิด  &nbsp;&nbsp;<input type="radio" name="captcha_lostpassword" value="yes" <?= ( 'yes' == $options['captcha_lostpassword'] ) ? "checked='checked'" : NULL ?> /> &nbsp;&nbsp;ปิด&nbsp;&nbsp;<input type="radio" name="captcha_lostpassword" value="no" <?= ( 'no' == $options['captcha_lostpassword'] ) ? "checked='checked'" : NULL ?> /></td>
            <td rowspan="3"><b>ตัวอย่าง</b><div id="lostpassword_show"></div></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีตัวอักษร</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="lostpassword_font_color" id="lostpassword_font_color" onchange="showimage('lostpassword_show')" value=<?=$options['lostpassword_font_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">สีพื้นหลัง</th>
            <td><input class="color {hash:true,pickerInset:5,pickerFaceColor:'#B8FCFC'}" name="lostpassword_bg_color" id="lostpassword_bg_color" onchange="showimage('lostpassword_show')" value=<?=$options['lostpassword_bg_color']?> /><br /><font color="red">เลือกสีที่ต้องการ</font></td>
        </tr>
        
        <tr><td colspan="4" style="border-bottom: ridge; border-bottom-color: gray">&nbsp;</td></tr>
        <tr><td>&nbsp</td></tr>
        
        <tr>
            <td colspan="4" align="center"><input type="submit" value="Save" /></td>
        </tr>
        <input type="hidden" name="cptch_form_submit" value="submit" /><br />
    
    </table>
</form>

<script type="text/javascript">
    <!--    
        showimage("login_show");
        showimage("register_show");
        showimage("comment_show");
        showimage("lostpassword_show");
    //-->
</script>

<?php
} // end function menu_page
?>