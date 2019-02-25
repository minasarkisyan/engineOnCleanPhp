<?php

class UserController extends Controller {

	public function actionEditProfile() {
		$message_avatar_name = "avatar";
		$message_name_name = "name";
		$message_password_name = "password";
		
		if ($this->request->change_avatar) {
			$img = $this->fp->uploadIMG($message_avatar_name, $_FILES["avatar"], Config::MAX_SIZE_AVATAR, Config::DIR_AVATAR);
			if ($img) {
				$tmp = $this->auth_user->getAvatar();
				$obj = $this->fp->process($message_avatar_name, $this->auth_user, array(array("avatar", $img)), array(), "SUCCESS_AVATAR_CHANGE");
				if ($obj instanceof UserDB) {
					if ($tmp) File::delete(Config::DIR_AVATAR.$tmp);
					$this->redirect(URL::current());
				}
			}
		}
		elseif ($this->request->change_name) {
			$checks = array(array($this->auth_user->checkPassword($this->request->password_current_name), true, "ERROR_PASSWORD_CURRENT"));
			$user_temp = $this->fp->process($message_name_name, $this->auth_user, array("name"), $checks, "SUCCESS_NAME_CHANGE");
			if ($user_temp instanceof UserDB) $this->redirect(URL::current());
		}
		elseif ($this->request->change_password) {
			$checks = array(array($this->auth_user->checkPassword($this->request->password_current), true, "ERROR_PASSWORD_CURRENT"));
			$checks[] = array($this->request->password, $this->request->password_conf, "ERROR_PASSWORD_CONF");
			$user_temp = $this->fp->process($message_password_name, $this->auth_user, array(array("setPassword()", $this->request->password)), $checks, "SUCCESS_PASSWORD_CHANGE");
			if ($user_temp instanceof UserDB) {
				$this->auth_user->login();
				$this->redirect(URL::current());
			}
		}
		
		$this->title = "Редактирование профиля";
		$this->meta_desc = "Редактирование профиля пользователя.";
		$this->meta_key = "редактирование профиля, редактирование профиля пользователя, редактирование профиля пользователя сайт";
		
		$form_avatar = new Form();
		$form_avatar->name = "change_avatar";
		$form_avatar->action = URL::current();
		$form_avatar->enctype = "multipart/form-data";
		$form_avatar->message = $this->fp->getSessionMessage($message_avatar_name);
		$form_avatar->file("avatar", "Аватар:");
		$form_avatar->submit("Сохранить");
		
		$form_avatar->addJSV("avatar", $this->jsv->avatar());
		
		$form_name = new Form();
		$form_name->name = "change_name";
		$form_name->header = "Изменить имя";
		$form_name->action = URL::current();
		$form_name->message = $this->fp->getSessionMessage($message_name_name);
		$form_name->text("name", "Ваше имя:", $this->auth_user->name);
		$form_name->password("password_current_name", "Текущий пароль:");
		$form_name->submit("Сохранить");
		
		$form_name->addJSV("name", $this->jsv->name());
		$form_name->addJSV("password_current_name", $this->jsv->password(false, false, "ERROR_PASSWORD_CURRENT_EMPTY"));
		
		$form_password = new Form();
		$form_password->name = "change_password";
		$form_password->header = "Изменить пароль";
		$form_password->action = URL::current();
		$form_password->message = $this->fp->getSessionMessage($message_password_name);
		$form_password->password("password", "Новый пароль:");
		$form_password->password("password_conf", "Повторите пароль:");
		$form_password->password("password_current", "Текущий пароль:");
		$form_password->submit("Сохранить");
		
		
		$form_name->addJSV("password", $this->jsv->password("password_conf"));
		$form_name->addJSV("password_current", $this->jsv->password(false, false, "ERROR_PASSWORD_CURRENT_EMPTY"));
		$hornav = $this->getHornav();
		$hornav->addData("Редактирование профиля");
		
		$this->render($this->renderData(array("hornav" => $hornav, "form_avatar" => $form_avatar, "form_name" => $form_name, "form_password" => $form_password), "profile", array("avatar" => $this->auth_user->avatar, "max_size" => (Config::MAX_SIZE_AVATAR / KB_B))));
	}
	
	protected function access() {
		if ($this->auth_user) return true;
		return false;
	}
	
}

?>