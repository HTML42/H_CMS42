<?php $Za=json_decode('["index.php","lib\/_html.php","lib\/bootstrap.php","lib\/render.php","version"]');function _get($Zb){if(is_string($Zb)&&strlen($Zb)>5){$Zb=trim($Zb);ob_start();$ch=curl_init();curl_setopt($ch,CURLOPT_URL, $Zb);curl_setopt($ch,CURLOPT_HEADER, false);$Zc=curl_exec($ch);curl_close($ch);$Zd=ob_get_clean();if(!in_array(trim($Zd),array('404:Not Found'))){return $Zd;}else{return null;}}return null;}function ensure_structure($Ze){if(is_string($Ze)){$Ze=array($Ze);}if(is_array($Ze)){foreach($Ze as $Zf){$Zg=explode('/',$Zf);$Zg=array_filter($Zg,'strlen');$Zh=(substr($Zf,0, 1)=='/'?'/':'');foreach($Zg as $Zi){$Zh .=$Zi.'/';if(!is_dir($Zh)){mkdir($Zh);}}}}}define('DIR_CMS',str_replace('/42', '', __DIR__). '/42/');$Zj=null;$Zk=DIR_CMS.'version';define('CMS_VERSION',(is_file($Zk)?trim(file_get_contents($Zk)):NULL));$Zl='https://raw.githubusercontent.com/HTML42/H_CMS42/master/';$Zq=$Zl.'updater/files/';$Zn=scandir(dirname(__DIR__));if(substr(__DIR__,-4)=='dist'&&in_array('demo',$Zn)&&in_array('updater',$Zn)){exit('<div>You are currently accessing to a source-File.</div>');}$Zo=_get($Zq.'version');define('CDN_VERSION',is_string($Zo)?$Zo:null);$Zj=false;if(!is_dir(DIR_CMS)){mkdir(DIR_CMS);$Zj=true;}if(!is_string(CMS_VERSION)||strlen(CMS_VERSION)<1){$Zj=true;}elseif(CMS_VERSION!=CDN_VERSION){$Zj=true;}if($Zj){if(isset($Za)&&is_array($Za)){foreach($Za as $Zp){ensure_structure(dirname(DIR_CMS.$Zp));file_put_contents(DIR_CMS.$Zp,_get($Zq.$Zp));}}file_put_contents(DIR_CMS.'update.php',_get($Zl.'dist/updater.min.php'));}unlink(__FILE__); ?><h3>Installation successfull</h3><p><a href="42/">Link to CMS42</a></p>