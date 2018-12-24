<?php
require_once 'core/init.php';

#$user = DB::getInstance()->query("SELECT username FROM users WHERE username = ?", array('almog'));

#$user = DB::getInstance()->get('users',array('username', '=','almog'));

#if(!$user->count()){
#    echo 'no user';
#}else{
#    foreach ($user->results() as $user){
#        echo $user->username;
#    }
#}


#DB::getInstance()->insert('users',array(
#    'username'=> 'almog',
#    'password'=> 'pass',
#    'salt'=> 'sss'
#
#));

/*
$userupdate = DB::getInstance()->update('users',3,array(
    'password'=>'newpasswprd',
    'name'=>'sababa'
));
*/
/*
if(Session::exists('home')){
    echo Session::flush( 'home');
}
*/

#echo Session::get(Config::get('session/session_name'));

#var_dump(DB::getInstance()->delete('users_session', array('user_id','=',10))) ;

if(Session::exists('home')){
    echo Session::flush( 'home');
}
$user = new User();


if($user->isloggedIn()){
?>

    <p>hello <a href="#"><?php echo escape(($user->data()->username));?></a></p> <!-- using htmlentities -->

    <ul>
        <li><a href="logout.php"> Log out</a> </li>
        <li><a href="update.php"> Update details</a> </li>
        <li><a href="changepassword.php"> Change password</a> </li>
        <li><a href="makeorder.php">Send you'r document to print</a> </li>
        <li><a href="myorder.php">my order datails</a> </li>
    </ul>

<?php
}else{
    echo '<p> you need to <a href="login.php">  log in </a>or <a href = "register.php"> register </a></p>';
}