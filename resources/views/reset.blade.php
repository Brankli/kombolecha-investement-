<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>investment website</title>
    </head>

    <body >
        <div class=" w-screen justify-center text-left"> 
            <h4 style="padding: 4px;">please click the link below to change the password</h4>
            <a  href="http://127.0.0.1:8000/#/chengepassword/{{$remrnbertoken}}" style="color:green; padding:2px" >reset link here</a>
        </div>
</script>
    </body>
</html>
