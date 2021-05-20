<?php

/**
 * Slimdown - A very basic regex-based Markdown parser. Supports the
 * following elements (and can be extended via Slimdown::add_rule()):
 *
 * - Headers
 * - Links
 * - Bold
 * - Emphasis
 * - Deletions
 * - Quotes
 * - Inline code
 * - Blockquotes
 * - Ordered/unordered lists
 * - Horizontal rules
 * ADDED MANUALLY:
 * - @user
 * - Display Pictures / YouTube Videos
 * - Code Block
 * Author: Johnny Broadway <johnny@johnnybroadway.com>
 * Website: https://gist.github.com/jbroadway/2836900
 * License: MIT
 */
class Slimdown {
	public static $rules = array (
		'/(#+)(.*)/' => 'self::header',                           // headers
        '/(^(?!\()|\s)((https?).*\.(jpe?g|bmp|png))/' => "<img src=\"https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/$2\" loading=lazy alt=\"$2\" style=\"max-width: 100%;\">",
        '/(^(?!\()|\s)((https?).*\.(gif))/' => "<img src=\"$2\" loading=lazy alt=\"$2\" style=\"max-width: 100%;\">",
        '/(^(?!\()|\s)(https?:\/\/(?:www\.|(?!www))(youtube\.com\/watch\?v\=|youtu\.be\/))([A-Za-z0-9-_][^\s|<]{1,})/' => "<iframe id=\"ytplayer\" allowFullScreen=\"allowFullScreen\" type=\"text/html\" width=\"544\" height=\"306\" src=\"https://www.youtube.com/embed/$4\"></iframe>",
		'/\[([^\[]+)\]\(([^\)]+)\)/' => '<a href=\'\2\'>\1</a>',  // links
		'/(\*\*|__)(.*?)\1/' => '<strong>\2</strong>',            // bold
		'/(\*|_)(.*?)\1/' => '<em>\2</em>',                       // emphasis
		'/\~\~(.*?)\~\~/' => '<del>\1</del>' ,                     // del
		'/\:\"(.*?)\"\:/' => '<q>\1</q>',                         // quote
        '/@([A-Za-z0-9-_]+[^\s|\W]{1,})/' => "<a href=\"/user/$1\">@$1</a>$2",
        //'/(\`\`\`)([^\`]+)(\`\`\`)/sm' => "<code style=\"max-width: 100%;\">$2<br /></code>",
		'/\n\*(.*)/' => 'self::ul_list',                          // ul lists
		'/\n[0-9]+\.(.*)/' => 'self::ol_list',                    // ol lists
		//'/\n(&gt;|\>)(.*)/' => 'self::blockquote ',               // blockquotes
		'/\n-{5,}/' => "\n<hr />",                                // horizontal rule
		'/\n([^\n]+)\n/' => 'self::para',                         // add paragraphs
		'/<\/ul>\s?<ul>/' => '',                                  // fix extra ul
		'/<\/ol>\s?<ol>/' => '',                                  // fix extra ol
		'/<\/blockquote><blockquote>/' => "\n"                    // fix extra blockquote
	);

	private static function para ($regs) {
		
		$line = $regs[1];
		$trimmed = trim ($line);
		if (preg_match ('/^<\/?(ul|ol|li|h|p|bl)/', $trimmed)) {
			return "\n" . $line . "\n";
		}
		return sprintf ("\n<p>%s</p>\n", $trimmed);
	}

	private static function ul_list ($regs) {
		$item = $regs[1];
		return sprintf ("\n<ul>\n\t<li>%s</li>\n</ul>", trim ($item));
	}

	private static function ol_list ($regs) {
		$item = $regs[1];
		return sprintf ("\n<ol>\n\t<li>%s</li>\n</ol>", trim ($item));
	}

	private static function blockquote ($regs) {
		$item = $regs[2];
		return sprintf ("\n<blockquote>%s</blockquote>", trim ($item));
	}

	private static function header ($regs) {
		list ($tmp, $chars, $header) = $regs;
		$level = strlen ($chars);
		return sprintf ('<h%d>%s</h%d>', $level, trim ($header), $level);
	}


	/**
	 * Render some Markdown into HTML.
	 */
	public static function render ($text) {
		$text = "\n" . $text . "\n";
		foreach (self::$rules as $regex => $replacement) {
			if (is_callable ( $replacement)) {
				$text = preg_replace_callback ($regex, $replacement, $text);
			} else {
				$text = preg_replace ($regex, $replacement, $text);
			}
		}
		return trim ($text);
	}
}

?>
