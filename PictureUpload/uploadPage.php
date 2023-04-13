<!DOCTYPE html>
<html>
<body>

<form action="uploadHandler.php"
method="post"
enctype="multipart/form-data">

Select Image to upload:
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="submit" value="Upload Image" name="submit">

</form>
<?php if( isset($_GET['error'])){ ?><?php echo $_GET['error']; }?>


</body>
</html>