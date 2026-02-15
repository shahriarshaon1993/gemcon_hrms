<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body style="font-family: times new roman"> 
    <div>
        <div style="background:aliceblue;width: 41%;text-align: center;font-weight: bold;padding: 9px;font-size: 15px;">Job Apply</div>
        <div >
            <p style="font-weight: bold;">Hello! {{$name}}</p>
            <p> {{ $email_body}} </p>
            <p style="width: 41%;">
                This your access information
                <br>Email : {{$email}}
                <br>
                <!-- <div style="text-align: center;width: 41%;"><button style="height: 34px;background:cornflowerblue;"><a style="color: #fff;padding: 10px;text-decoration: none;" href="http://surveys.gemconit.com/">Login Now</a></button>
                    or : Login Link : http://surveys.gemconit.com/
                </div> -->

                <p>If You Feel Any problem contact our email : info@gemcongroup.com <br><p style="font-weight: bold;">Regrads</p>  <br> Gemcon Group</p>
            </p>
        </div>
        <div style="background:aliceblue;width: 41%;text-align: center;font-weight: bold;padding: 9px;font-size: 15px;">© <?php echo  date('Y'); ?>  gemcongroup.com All rights reserved. Developed by Gemcon Group IT.</div>
    </div>
</body>
</html>