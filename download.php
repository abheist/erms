<?php     
if(isset($_POST['submit'])){
    $resume='resumes/'.$_POST['candid'].'.'.$_POST['file'];
    $name=$_POST['candidate'].'.'.$_POST['file'];
 if (file_exists($resume)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename='.$name);
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($resume));
                readfile($resume);
                exit;
                }
                else{
                    echo $resume;
                    echo '<br>no such file';
                }
                }
        ?>