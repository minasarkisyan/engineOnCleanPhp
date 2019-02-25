<?php

class MainController extends Controller {

	public function actionIndex() {
		$this->title = "Как создать свой сайт";
		$this->meta_desc = "Как создать свой сайт? Ответ на этот вопрос находится на этом сайте. Огромное количество материалов по темам: как создать свой сайт и как раскрутить сайт!";
		$this->meta_key = "как создать свой сайт, создание сайта";
		
		$articles = ArticleDB::getAllShow(Config::COUNT_ARTICLES_ON_PAGE, $this->getOffset(Config::COUNT_ARTICLES_ON_PAGE), true);
		$pagination = $this->getPagination(ArticleDB::getCount(), Config::COUNT_ARTICLES_ON_PAGE, "/");
		$blog = new Blog();
		$blog->articles = $articles;
		$blog->pagination = $pagination;
		$this->render($this->renderData(array("blog" => $blog), "index"));
	}
	
	public function actionSection() {
		$section_db = new SectionDB();
		$section_db->load($this->request->id);
		if (!$section_db->isSaved()) $this->notFound();
		$this->section_id = $section_db->id;
		$this->title = $section_db->title;
		$this->meta_desc = $section_db->meta_desc;
		$this->meta_key = $section_db->meta_key;
		
		$hornav = $this->getHornav();
		$hornav->addData($section_db->title);
		
		$intro = new Intro();
		$intro->hornav = $hornav;
		$intro->obj = $section_db;
		
		$blog = new Blog();
		$articles = ArticleDB::getAllOnPageAndSectionID($this->request->id, Config::COUNT_ARTICLES_ON_PAGE);
		
		$more_articles = ArticleDB::getAllOnSectionID($this->request->id, false);
		
		$i = 0;
		foreach ($more_articles as $id => $article) {
			$i++;
			unset($more_articles[$id]);
			if ($i == Config::COUNT_ARTICLES_ON_PAGE) break;
		}
		
		$blog->articles = $articles;
		$blog->more_articles = $more_articles;
		$this->render($intro.$blog);
	}
	
	public function actionCategory() {
		$category_db = new CategoryDB();
		$category_db->load($this->request->id);
		if (!$category_db->isSaved()) $this->notFound();
		$this->section_id = $category_db->section_id;
		$this->title = $category_db->title;
		$this->meta_desc = $category_db->meta_desc;
		$this->meta_key = $category_db->meta_key;
		
		$section_db = new SectionDB();
		$section_db->load($category_db->section_id);
		
		$hornav = $this->getHornav();
		$hornav->addData($section_db->title, $section_db->link);
		$hornav->addData($category_db->title);
		
		$intro = new Intro();
		$intro->hornav = $hornav;
		$intro->obj = $category_db;
		
		$category = new Category();
		$articles = ArticleDB::getAllOnCatID($this->request->id, Config::COUNT_ARTICLES_ON_PAGE);
				
		$category->articles = $articles;
		
		$this->render($intro.$category);
	}
	
	public function actionArticle() {
		$article_db = new ArticleDB();
		$article_db->load($this->request->id);
		if (!$article_db->isSaved()) $this->notFound();
		$this->title = $article_db->title;
		$this->meta_desc = $article_db->meta_desc;
		$this->meta_key = $article_db->meta_key;
		
		$hornav = $this->getHornav();
		
		if ($article_db->section) {
			$this->section_id = $article_db->section->id;
			$hornav->addData($article_db->section->title, $article_db->section->link);
			$this->url_active  = URL::get("section", "", array("id" => $article_db->section->id));
		}
		if ($article_db->category) {
			$hornav->addData($article_db->category->title, $article_db->category->link);
			$this->url_active  = URL::get("category", "", array("id" => $article_db->category->id));
		}
		
		$hornav->addData($article_db->title);
		
		$prev_article_db = new ArticleDB();
		$prev_article_db->loadPrevArticle($article_db);
		$next_article_db = new ArticleDB();
		$next_article_db->loadNextArticle($article_db);
		
		$article = new Article();
		$article->hornav = $hornav;
		$article->auth_user = $this->auth_user;
		$article->article = $article_db;
		if ($prev_article_db->isSaved()) $article->prev_article = $prev_article_db;
		if ($next_article_db->isSaved()) $article->next_article = $next_article_db;
		
		$article->link_register = URL::get("register");
		
		$comments = CommentDB::getAllOnArticleID($article_db->id);
		$article->comments = $comments;
		
		$this->render($article);
	}
	
	public function actionPoll() {
		$message_name = "poll";
		if ($this->request->poll) {
			$poll_voter_db = new PollVoterDB();
			$poll_data = PollDataDB::getAllOnPollID($this->request->id);
			$already_poll = PollVoterDB::isAlreadyPoll(array_keys($poll_data));
			$checks = array(array($already_poll, false, "ERROR_ALREADY_POLL"));
			$this->fp->process($message_name, $poll_voter_db, array("poll_data_id"), $checks, "SUCCESS_POLL");
			$this->redirect(URL::current());
		}
		$poll_db = new PollDB();
		$poll_db->load($this->request->id);
		if (!$poll_db->isSaved()) $this->notFound();
		$this->title = "Результаты голосования: ".$poll_db->title;
		$this->meta_desc = "Результаты голосования: ".$poll_db->title.".";
		$this->meta_key = "результаты голосования, ".mb_strtolower($poll_db->title);
		
		$poll_data = PollDataDB::getAllDataOnPollID($poll_db->id);
		
		$hornav = $this->getHornav();
		$hornav->addData($poll_db->title);
		
		$poll_result = new PollResult();
		$poll_result->hornav = $hornav;
		$poll_result->message = $this->fp->getSessionMessage($message_name);
		$poll_result->title = $poll_db->title;
		$poll_result->data = $poll_data;
		
		$this->render($poll_result);
		
	}
	
	public function actionRegister() {
		$message_name = "register";
		if ($this->request->register) {
			$user_old_1 = new UserDB();
			$user_old_1->loadOnEmail($this->request->email);
			$user_old_2 = new UserDB();
			$user_old_2->loadOnLogin($this->request->login);
			$captcha = $this->request->captcha;
			$checks = array(array(Captcha::check($captcha), true, "ERROR_CAPTCHA_CONTENT"));
			$checks[] = array($this->request->password, $this->request->password_conf, "ERROR_PASSWORD_CONF");
			$checks[] = array($user_old_1->isSaved(), false, "ERROR_EMAIL_ALREADY_EXISTS");
			$checks[] = array($user_old_2->isSaved(), false, "ERROR_LOGIN_ALREADY_EXISTS");
			$user = new UserDB();
			$fields = array("name", "login", "email", array("setPassword()", $this->request->password));
			$user = $this->fp->process($message_name, $user, $fields, $checks);
			if ($user instanceof UserDB) {
				$this->mail->send($user->email, array("user" => $user, "link" => URL::get("activate", "", array("login" => $user->login, "key" => $user->activation), false, Config::ADDRESS)), "register");
				$this->redirect(URL::get("sregister"));
			}
		}
		$this->title = "Регистрация на сайте ".Config::SITENAME;
		$this->meta_desc = "Регистрация на сайте ".Config::SITENAME.".";
		$this->meta_key = "регистрация сайт ".mb_strtolower(Config::SITENAME).", зарегистрироваться сайт ".mb_strtolower(Config::SITENAME);
		$hornav = $this->getHornav();
		$hornav->addData("Регистрация");
		
		$form = new Form();
		$form->hornav = $hornav;
		$form->header = "Регистрация";
		$form->name = "register";
		$form->action = URL::current();
		$form->message = $this->fp->getSessionMessage($message_name);
		$form->text("name", "Имя и/или фамилия:", $this->request->name);
		$form->text("login", "Логин:", $this->request->login);
		$form->text("email", "E-mail:", $this->request->email);
		$form->password("password", "Пароль:");
		$form->password("password_conf", "Подтвердите пароль:");
		$form->captcha("captcha", "Введите код с картинки:");
		$form->submit("Регистрация");
		
		$form->addJSV("name", $this->jsv->name());
		$form->addJSV("login", $this->jsv->login());
		$form->addJSV("email", $this->jsv->email());
		$form->addJSV("password", $this->jsv->password("password_conf"));
		$form->addJSV("captcha", $this->jsv->captcha());
		
		$this->render($form);
		
	}
	
	public function actionSRegister() {
		$this->title = "Регистрация на сайте ".Config::SITENAME;
		$this->meta_desc = "Регистрация на сайте ".Config::SITENAME.".";
		$this->meta_key = "регистрация сайт ".mb_strtolower(Config::SITENAME).", зарегистрироваться сайт ".mb_strtolower(Config::SITENAME);
	
		$hornav = $this->getHornav();
		$hornav->addData("Регистрация");
		
		$pm = new PageMessage();
		$pm->hornav = $hornav;
		$pm->header = "Регистрация";
		$pm->text = "Учётная запись создана. На указанный Вами адрес электронной почты отправлено письмо с инструкцией по активации. Если письмо не доходит, то обратитесь к администрации.";
		$this->render($pm);
	}
	
	public function actionActivate() {
		$user_db = new UserDB();
		$user_db->loadOnLogin($this->request->login);
		$hornav = $this->getHornav();
		if ($user_db->isSaved() && ($user_db->activation == "")) {
			$this->title = "Ваш аккаунт уже активирован";
			$this->meta_desc = "Вы можете войти в свой аккаунт, используя Ваши логин и пароль.";
			$this->meta_key = "активация, успешная активация, успешная активация регистрация";
			$hornav->addData("Активация");
		}
		elseif ($user_db->activation != $this->request->key) {
			$this->title = "Ошибка при активации";
			$this->meta_desc = "Неверный код активации! Если ошибка будет повторяться, то обратитесь к администрации.";
			$this->meta_key = "активация, ошибка активация, ошибка активация регистрация";
			$hornav->addData("Ошибка активации");
		}
		else {
			$user_db->activation = "";
			try {
				$user_db->save();
			} catch (Exception $e) {print_r($e->getMessage());}
			$this->title = "Ваш аккаунт успешно активирован";
			$this->meta_desc = "Теперь Вы можете войти в свою учётную запись, используя Ваши логин и пароль.";
			$this->meta_key = "активация, успешная активация, успешная активация регистрация";
			$hornav->addData("Активация");
		}
		
		$pm = new PageMessage();
		$pm->hornav = $hornav;
		$pm->header = $this->title;
		$pm->text = $this->meta_desc;
		$this->render($pm);
	}
	
	public function actionLogout() {
		UserDB::logout();
		$this->redirect($_SERVER["HTTP_REFERER"]);
	}
	
	public function actionReset() {
		$message_name = "reset";
		$this->title = "Восстановление пароля";
		$this->meta_desc = "Восстановление пароля пользователя.";
		$this->meta_key = "восстановление пароля, восстановление пароля пользователя";
		$hornav = $this->getHornav();
		$hornav->addData("Восстановление пароля");
		if ($this->request->reset) {
			$user_db = new UserDB();
			$user_db->loadOnEmail($this->request->email);
			if ($user_db->isSaved()) $this->mail->send($user_db->email, array("user" => $user_db, "link" => URL::get("reset", "", array("email" => $user_db->email, "key" => $user_db->getSecretKey()), false, Config::ADDRESS)), "reset");
			$pm = new PageMessage();
			$pm->hornav = $hornav;
			$pm->header = "Восстановление пароля";
			$pm->text = "Инструкция по восстановлению пароля выслана на указанный e-mail адрес.";
			$this->render($pm);
		}
		elseif ($this->request->key) {
			$user_db = new UserDB();
			$user_db->loadOnEmail($this->request->email);
			if ($user_db->isSaved() && ($this->request->key === $user_db->getSecretKey())) {
				if ($this->request->reset_password) {
					$checks = array(array($this->request->password_reset, $this->request->password_reset_conf, "ERROR_PASSWORD_CONF"));
					$user_db = $this->fp->process($message_name, $user_db, array(array("setPassword()", $this->request->password_reset)), $checks);
					if ($user_db instanceof UserDB) {
						$user_db->login();
						$this->redirect(URL::get("sreset"));
					}
				}
				$form = new Form();
				$form->hornav = $hornav;
				$form->header = "Восстановление пароля";
				$form->name = "reset_password";
				$form->action = URL::current();
				$from->message = $this->fp->getSessionMessage($message_name);
				$form->password("password_reset", "Новый пароль:");
				$form->password("password_reset_conf", "Повторите пароль:");
				$form->submit("Далее");
				
				$form->addJSV("password_reset", $this->jsv->password("password_reset_conf"));
				$this->render($form);
			}
			else {
				$pm = new PageMessage();
				$pm->hornav = $hornav;
				$pm->header = "Неверный ключ";
				$pm->text = "Попробуйте ещё раз, если ошибка будет повторяться, то обратитесь к администрации.";
				$this->render($pm);
			}
		}
		else {
			$form = $this->getFormEmail("Восстановление пароля", "reset", $message_name);
			$form->hornav = $hornav;
			$this->render($form);
		}
	}
	
	public function actionSReset() {
		$this->title = "Восстановление пароля";
		$this->meta_desc = "Восстановление пароля успешно завершено.";
		$this->meta_key = "восстановление пароля, восстановление пароля пользователя, восстановление пароля пользователя завершено";
		
		$hornav = $this->getHornav();
		$hornav->addData("Восстановление пароля");
		
		$pm = new PageMessage();
		$pm->hornav = $hornav;
		$pm->header = "Пароль успешно изменён!";
		$pm->text = "Теперь Вы можете войти на сайт, если Вы не авторизовались автоматически.";
		
		$this->render($pm);
	}
	
	public function actionRemind() {
		$this->title = "Восстановление логина";
		$this->meta_desc = "Восстановление логина пользователя.";
		$this->meta_key = "восстановление логина, восстановление логина пользователя";
		$hornav = $this->getHornav();
		$hornav->addData("Восстановление логина");
		if ($this->request->remind) {
			$user_db = new UserDB();
			$user_db->loadOnEmail($this->request->email);
			if ($user_db->isSaved()) $this->mail->send($user_db->email, array("user" => $user_db), "remind");
			$pm = new PageMessage();
			$pm->hornav = $hornav;
			$pm->header = "Восстановление логина";
			$pm->text = "Письмо с Вашим логином отправлено на указанный e-mail адрес.";
			$this->render($pm);
		}
		else {
			$form = $this->getFormEmail("Восстановление логина", "remind", "remind");
			$form->hornav = $hornav;
			$this->render($form);
		}
	}
	
	public function actionSearch() {
		$hornav = $this->getHornav();
		$hornav->addData("Поиск");
		$this->title = "Поиск: ".$this->request->query;
		$this->meta_desc = "Поиск ".$this->request->query.".";
		$this->meta_key = "поиск, поиск ".$this->request->query;
		$articles = ArticleDB::search($this->request->query);
		$sr = new SearchResult();
		if (mb_strlen($this->request->query) < Config::MIN_SEARCH_LEN) $sr->error_len = true;
		$sr->hornav = $hornav;
		$sr->field = "full";
		$sr->query = $this->request->query;
		$sr->data = $articles;
		
		$this->render($sr);
	}
	
	private function getFormEmail($header, $name, $message_name) {
		$form = new Form();
		$form->header = $header;
		$form->name = $name;
		$form->action = URL::current();
		$form->message = $this->fp->getSessionMessage($message_name);
		$form->text("email", "Введите e-mail, указанный при регистрации:", $this->request->email);
		$form->submit("Далее");
		$form->addJSV("email", $this->jsv->email());
		return $form;
	}
	
}

?>