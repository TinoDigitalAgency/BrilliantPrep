<?php
/**
 * Шаблон комментариев (comments.php)
 * Выводит список комментариев и форму добавления
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<div id="comments" class="comments-area"> <?php // див с этим id нужен для якорьных ссылок на комменты ?>
    <h2 class="comments-title h3">
        Comments
        <span class="comment-count"><?php echo get_comments_number() ?></span>
    </h2>
    <p class="subtitle">Your email address will not be published. All fields are required</p>
	<?php if (comments_open()) { // если комментирование включено для данного поста
		/* ФОРМА КОММЕНТИРОВАНИЯ */
		$fields =  array( // разметка текстовых полей формы
			'author' => '<div class="form-row"><div class="form-col col-6"><input id="author" placeholder="Name" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30" required></div>',
			'email' => '<div class="form-col col-6"><input class="form-control" placeholder="Email" id="email" name="email" type="email" value="'.esc_attr($commenter['comment_author_email']).'" size="30" required></div></div>',
			'url' => '<div class="form-group hidden"><label for="url">Сайт</label><input class="form-control" id="url" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'" size="30"></div>',
		);
		$args = array( // опции формы комментирования
			'fields' => apply_filters('comment_form_default_fields', $fields), // заменяем стандартные поля на поля из массива выше ($fields)
			'comment_field' => '<div class="form-row"><div class="form-col col-12"><textarea class="form-control" id="comment" name="comment" placeholder="Comment" cols="45" rows="8" required></textarea></div></div>', // разметка поля для комментирования
			'must_log_in' => '<p class="must-log-in">You must be registered! '.wp_login_url(apply_filters('the_permalink',get_permalink())).'</p>', // текст "Вы должны быть зарегистрированы!"
			'logged_in_as' => '<p class="author-notice-logout">'.sprintf(__( 'Hello <a href="%1$s">%2$s</a>. <a href="%3$s">Logout?</a>'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink',get_permalink()))).'</p>', // разметка "Вы вошли как"
			'comment_notes_before' => '', // Текст до формы
			'comment_notes_after' => '', // текст после формы
			'id_form' => 'commentform', // атрибут id формы
			'id_submit' => 'submit', // атрибут id кнопки отправить
			'title_reply' => 'Comment', // заголовок формы
			'title_reply_to' => 'Reply %s', // "Ответить" текст
			'cancel_reply_link' => 'Cancel reply', // "Отменить ответ" текст
			'label_submit' => 'Submit', // Текст на кнопке отправить
			'class_submit' => 'btn btn-pink' // новый параметр с классом копки, добавлен с 4.1
		);
		comment_form($args); // показываем нашу форму
	} ?>
	<?php if (have_comments()) : // если комменты есть ?>
		<ul class="comment-list media-list">
			<?php
			wp_list_comments(); // выводим комменты
			?>
		</ul>
	<?php endif; // // если комменты есть - конец ?>

</div>