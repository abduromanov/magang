<?php $this->load->view('head'); ?>
<body>
    <div class="inner-banner-agile"></div>

    <section class="main-sec-w3 pb-5">
        <div class="container">
            <div class="wthree-inner-sec">
                <div class="sec-head">
                    <h1 class="sec-title-w3 text-capitalize">login</h1>
                    <span class="block"></span>
                </div>
                
                <div class="form-wrapper">
                    <?= (isset($message['message']))? $message['message'] : ""; ?>
                    <form action="<?php echo base_url(); ?>logged_in" method="post">
                        <div class="d-flex flex-column">
                            <label>Username</label>
                            <input class="text-input" type="text" name="username" required>
                        </div><br>
                        
                        <div class="d-flex flex-column my-sm-5 my-3">
                            <label>Password</label>
                            <input class="text-input" type="password" name="password" required>
                        </div><br>

                        <input class="submit" type="submit" value="Login">
                        <button class="submit" type="button" onclick="window.open('<?php echo base_url();?>','_self');">Go Home</button>
                    </form>
                </div>
            </div>            
        </div>
    </section>
    
    <?php $this->load->view('footer'); ?>
</body>