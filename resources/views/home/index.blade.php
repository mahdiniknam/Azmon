<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('assets/home/css/bootstrap.rtl.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/home/css/bootstrap-icon.css')}}">
  <link rel="stylesheet" href="{{asset('assets/home/css/animate.css')}}">
  <link rel="stylesheet" href="{{asset('assets/home/style.css')}}">
  <title>آزمون ساز آنلاین</title>
</head>
<body>
 <div class="container">
  <div class="row justify-content-center align-items-center py-5 py-sm-0" style="min-height: 100vh;">
    <div class="col-md-10 col-lg-8 col-xl-7">
      <div class="text-center">
        <h1 class="example display-1 text-white ">آزمون ساز آنلاین</h1>
        <div class="my-2 wow animate__animated animate__fadeInUp" data-wow-duration="2s" data-wow-delay="1.5s">
          <a href="{{route('student.login')}}" class="d-inline-block px-4 py-2 rounded bg-white text-dark mx-1">پنل دانشجو</a>
        <a href="{{route('teacher.login')}}" class="my-2 d-inline-block px-4 py-2 rounded text-white  bg-ae mx-1">پنل استاد</a>
        </div>
        <h2 class="text-white opacity-75 my-4 wow animate__animated animate__fadeInUp" data-wow-duration="2s" data-wow-delay="1.5s">تجربه شیرین سنجش با آزمون ساز آنلاین</h2>
        <a href="https://github.com/mahdiniknam" target="_blank" class="read-more position-relative d-inline-block text-white wow animate__animated animate__fadeInUp" data-wow-duration="2s" data-wow-delay="1.5s">محمد مهدی نیکنام شارک</a>
      </div>
    </div>
  </div>
 </div>
 <script src="{{asset('assets/home/js/jQuery.js')}}"></script>
 <script src="{{asset('assets/home/js/jquery.liveType.js')}}"></script>
 <script src="{{asset('assets/home/js/wow.js')}}"></script>
 <script type="text/javascript">
  jQuery(document).ready(function(){
      jQuery('.example').liveType({
        typeSpeed          : 100,      
        pauseEvery         : 40, 
        pauseTime          : 1500,   
        pauseOnPunctuation : true,     
        punctuationChars   : ['.', '.', '?', '!', ':', ';'],  
        cursorEffect       : true,                            
        cursorSpeed        : 1000,    
        cursor             : '', 
        cursorClass        : 'cursor'   
      });
  })
  new WOW().init();
</script>
</body>
</html>