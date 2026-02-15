<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body style="font-family: times new roman"> 
    <div>
        <div style="background:#15b22f;width: 41%;text-align: center;font-weight: bold;padding: 9px;font-size: 15px;">Examiner Mail</div>
        <div >
            <p style="font-weight: bold;">Hello! {{$name}}</p>
            <p> {{ $email_body}} </p>
            <p style="width: 41%;">
                This your access information for selecting an employee.
                <br>Link: <a href="{{$access_link}}" target="_blank">{{$access_link}}</a>
                <!-- <br>Email : {{$email}} -->
                <p>If You Feel Any problem contact our email : info@gemcongroup.com <br><p style="font-weight: bold;">Regrads</p>  <br> Gemcon Group</p>
            </p>
        </div>
        <div style="background:#15b22f;width: 41%;text-align: center;font-weight: bold;padding: 9px;font-size: 15px;">© <?php echo  date('Y'); ?>  gemcongroup.com All rights reserved. Developed by Gemcon Group IT.</div>
    </div>
</body>
</html>