﻿=== CAPTCHA in Thai ===
Contributors: Thanate, nattapon_wora
Donate link: http://www.captcha.in.th/
Tags: captcha, thai, spam, comment
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.1

แคปต์ชาในภาษาไทย

== Description ==

CAPTCHA in Thai เป็นการบริการฟรีแคปต์ชา ที่เป็นภาษาไทย ในลักษณะของการแก้ไขคำที่มักเขียนผิด คำอ่าน และสุภาษิตต่างๆ 
เพื่อช่วยป้องกันเว็บไซต์ของท่านจากสแปม ท่านสามารถติดตั้งใช้ได้หลายส่วน ได้แก่ การเข้าสู่ระบบ, การลงทะเบียนและการแสดงความคิดเห็น 
นอกจากนี้การใช้ CAPTCHA in Thai เป็นการส่งเสริมให้ผู้ใช้งานสามารถใช้ภาษาไทยได้ถูกต้องอีกด้วย

= การทำงาน =
1. เมื่อผู้ใช้เข้าหน้าที่ถูกตั้งค่าให้ใช้งานแคปต์ชา จะมีการร้องขอภาพคำถามจาก server โดยมีการส่ง ip address 
ของผู้ที่ต้องตอบแคปต์ชา และ hostname ที่ติดตั้งปลั๊กอิน เพื่อใช้ในการเก็บสถิติไปด้วย
2. เมื่อผู้ใช้ ทำการกรอกข้อมูลในหน้านั้นๆ พร้อมกับคำตอบของแคปต์ชา ปลั๊กอินจะส่งคำตอบกลับไปตรวจสอบที่เซิฟเวอร์ 
พร้อม ip address ของผู้ตอบ และชื่อ hostname ที่ติดตั้งปลั๊กอิน จากนั้นเซิฟเวอร์จะทำการส่งข้อมูลว่าถูกหรือผิดกลับมา

= ปลั๊กอินนี้จะช่วยอะไรคุณได้บ้าง: =

* ช่วยให้เว็บของคุณมีการป้องกันสแปมผ่านแคปต์ชา ในรูปแบบภาษาไทย
* สามารถเลือกการใช้บริการได้หลากหลายรูปแบบ ได้แก่ คำที่มักเขียนผิด คำอ่าน และสุภาษิต และเรียกใช้ได้หลายส่วนการทำงาน
* สามารถเลือกสีของตัวอักษร, สีของพื้นหลัง, รูปแบบของตัวอักษรได้
* สามารถเลือกเลือกระดับของการป้องกันได้
* มีระบบ Offline ป้องกันในกรณีที่ไม่สามารถติดต่อกับเซิร์ฟเวอร์ของเราได้

= Credit =
* การจัดทำปลั๊กอินแคปต์ชาในภาษาไทย เป็นส่วนหนึ่งของการทำโครงงานในวิชา CN405 COMPUTER ENGINEERING PROJECT II คณะวิศวกรรมศาสตร์ ภาควิชาไฟฟ้าและคอมพิวเตอร์ มหาวิทยาลัยธรรมศาสตร์ โดยมีอาจารย์ วชิรา พรหมสาขา ณ สกลนคร เป็นอาจารย์ที่ปรึกษา 
* Source code ของ Color Picker จาก  jscolor.com
* ปลั๊กอิน captcha ที่นำมาศึกษา ของ BestWebSoft

== Installation ==

1. ติดตั้ง CAPTCHA in Thai ลงในโฟล์เดอร์ /wp-content/plugins/
2. คลิกที่ Active ของปลั๊กอิน CAPTCHA in Thai ในเมนูของปลั๊กอินใน Wordpress
3. คลิก Settings ในปลั๊กอินแคปต์ชา เพื่อเลือกรูปแบบการทำงาน  

== Screenshots ==

1. หน้าการตั้งค่า plugin
2. ตัวอย่าง captcha in Thai ในหมวดคำถามประเภทแก้ไขคำที่มักเขียนผิด
3. ตัวอย่าง captcha in Thai ในหมวดคำถามประเภทเขียนคำเขียนจากคำอ่าน
4. ตัวอย่าง captcha in Thai ในหมวดคำถามประเภทเติมสำนวน สุภาษิต

== Frequently Asked Questions ==

= แคปต์ชา (CAPTCHA) คืออะไร? =

CAPTCHA (Completely Automated Public Turing Test To Tell Computers and Humans Apart) 
คือ ระบบที่ใช้ทดสอบเพื่อจำแนกความแตกต่างระหว่างมนุษย์และคอมพิวเตอร์ได้อย่างสมบูรณ์ โดยสร้างการทดสอบที่มนุษย์สามารถแก้ปัญหาได้อย่างถูกต้อง 
แต่คอมพิวเตอร์ในปัจจุบันไม่สามารถแก้ปัญหานี้ได้

= แคปต์ชามีประโยชน์อย่างไร? =

แคปต์ชาจะช่วยป้องกันการสมัครการใช้งานต่างๆของเว็บไซต์และป้องกันสแปม จากโปรแกรมอัตโนมัติ (bots) โดยการนำแคปต์ชามาใช้กับ
แบบฟอร์มการสมัครสมาชิกหรือแบบฟอร์มป้อนข้อความต่างๆ เพื่อเป็นการยืนยันว่า ผู้ที่กรอกแบบฟอร์มเป็นมนุษย์ เนื่องจากโปรแกรมอัตโนมัติเหล่านี้จะ
ไม่สามารถแก้ปัญหาจากแคปต์ชาได้

= ทำไมต้องเป็นรูปแบบภาษาไทย? =

เนื่องจากในปัจจุบัน แคปต์ชาที่เป็นภาษาไทยยังมีจำนวนน้อย และไม่สะดวกในการนำมาใช้งาน จึงได้จัดทำแคปต์ชา ในรูปแบบภาษาไทยขึ้นมา
อีกทั้งยังเป็นรูปแบบการใช้คำที่มักเขียนผิดในภาษาไทยเพื่อเป็นการส่งเสริมให้ผู้ใช้งานสามารถใช้ภาษาไทยได้ถูกต้องมากขึ้นอีกด้วย


== Changelog ==
= 1.1 =
* แก้ไขชื่อไฟล์ และ url ใน source code เพื่อแก้ปัญหาการชื่อ folder ที่ผิดพลาด

= 1.0 =
* เวอร์ชั่นเริ่มต้นของ CAPTCHA ในรูปแบบภาษาไทย

== Upgrade Notice ==
= 1.1 =
 แก้ไขให้ color picker และ ภาพแคปต์ชาตัวอย่างสามารถใช้งานและแสดงผลได้

= 1.0 =
เวอร์ชั่นเริ่มต้นของ  แคปต์ชาในภาษาไทย


