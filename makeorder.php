<?php
require_once 'core/init.php';
$user = new User();
if (!$user->isloggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token') )){
        if(!($_FILES['file']['size'])==0) {

            $validate = new Validate();
            $validation = $validate->check($_FILES['file'], array(
                'size' => array('max' => Config::get('uploads/max_size')),
                'name' => array('max' => Config::get('uploads/max_name'))
            ));

            if ($validation->passed()) {
                $tmp_name = Input::get_file_info('file','tmp_name');

                $file_info = new finfo(FILEINFO_MIME);
                $mime_type = $file_info->buffer(file_get_contents($tmp_name));

                $mime_type = strstr($mime_type, ';', true);

                $extension = strstr($mime_type, '/');
                $extension = substr($extension, 1);

                $new_name = Config::get('uploads/destination') . Hash::unique() . '.' .$extension;

                $descripation = Input::get('side') . ' ' . Input::get('color') . ' ' . Input::get('binding');

                if (!(in_array($mime_type, Config::get('uploads/allowed')))) {
                    echo 'file format is not support';
                } else {
                    try {
                        $user->insert_order(array(
                            'user_id'=> $user->data()->id,
                            'file_name'=> $new_name,
                            'status'=> 0,
                            'details'=> $descripation

                        ));

                    }catch (Exception $e){
                        die($e->getMessage());
                    }
                    move_uploaded_file($tmp_name, $new_name);

                }
            } else {
                foreach ($validation->errors() as $error) {
                    echo $error . '<br>';
                }
            }
        }else {
            echo 'you must choose file';
}

}
}
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="field">

        <select name="side">
            <option value="one_side">one side</option>
            <option value="dual_side">dual side</option>
        </select>

        <br>

        <select name="color">
            <option value="black_and_white">black and white</option>
            <option value="color">color</option>
        </select>

        <br>

        <select name="binding">
            <option value="metal_spiral">metal spiral</option>
            <option value="plastic_spiral">plastic spiral</option>
            <option value="punch">punch</option>
            <option value="glue">glue</option>
        </select>

        <br>

        <input type="file" name="file">

        <br>

        <input type="submit" value="send" name="submit">

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">

    </div>

</form>
