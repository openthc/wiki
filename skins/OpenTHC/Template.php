<?php
/**
 * BaseTemplate class for the Timeless skin
 */
class OpenTHC_Template extends BaseTemplate {

	/** @var array */
	protected $pileOfTools;

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute()
	{
		$this->pileOfTools = $this->getPageTools();

		// Login/User Menu
		$userLinks = $this->getUserLinks();

		// Open html, body elements, etc
		//$html = $this->get( 'headelement' );
		$t = $this->get('title');
		$html = <<<EOH
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="viewport" content="initial-scale=1, user-scalable=yes">
<meta name="application-name" content="OpenTHC">
<meta name="apple-mobile-web-app-title" content="OpenTHC">
<meta name="msapplication-TileColor" content="#003100">
<meta name="theme-color" content="#003100">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha256-eSi1q2PG6J7g7ib17yAaWMcrr5GrtohYChqibrV7PBE=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://openthc.com/css/html.css">
<link rel="stylesheet" href="/skins/OpenTHC/wiki.css">
<title>$t</title>
</head>
<body>
EOH;

		$home_link = htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );
		$home_html = '<img alt="Home" src="https://openthc.com/img/icon.png" style="height:24px;width:24px;">';

		$html .= Html::openElement('nav', [ 'id' => 'menu-zero', 'class' => 'navbar navbar-expand-md navbar-dark bg-dark sticky-top' ]);
		$html .= Html::rawElement('a', [ 'class' => 'navbar-brand', 'href' => $home_link ], $home_html);

		$html .= '<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#ot-menu-head" aria-expanded="false" aria-controls="ot-menu-head"><span class="navbar-toggler-icon"></span></button>';
		$html .= '<div class="navbar-collapse collapse" id="ot-menu-head">';

		$html .= '<ul class="navbar-nav mr-auto">';
		//$html .= '<li class="nav-item"><a class="nav-link" href="/faq">FAQ</a></li>';
		//$html .= '<li class="nav-item"><a class="nav-link" href="/kb">KB</a></li>';
		$html .= '<li class="nav-item"><a class="nav-link" href="/Sops">SOPs</a></li>';
		$html .= '</ul>';

		$html .= $this->getMenuZeroSearch();

		$html .= $this->getMenuZeroSecondary();

		$html .= '</div>';
		$html .= Html::closeElement('nav');

		$html .= '<div class="main-wrap">';

		$html .= '<div class="main-menu">';
		$html .= '<div style="margin:0.25em; padding: 0;">';
			// $html.= '<div>';
			// $html.= $this->getLogo( 'p-logo', 'image' );
			// $html.= '</div>';

			$html.= '<div class="menu-main-part1">';
			$html.= $this->getMainNavigation();
			$html.= '</div>';

			$html.= '<div class="menu-main-part0">';
			$html.= $this->getSidebarChunk(
				'site-tools',
				'openthc-sitetools',
				$this->getPortlet(
					'tb',
					$this->pileOfTools['general'],
					'openthc-sitetools'
				)
			);
			$html.= '</div>';

			$html.= Html::rawElement( 'div', [ 'id' => 'mw-related-navigation' ],
				$this->getPageToolSidebar() .
				$this->getInterlanguageLinks() .
				$this->getCategories()
			);
		$html .= '</div>';
		$html .= '</div>'; // /.main-menu

		$html .= '<div class="main-body">';

			$html .= Html::rawElement('h1', [ 'id' => 'firstHeading', 'class' => 'firstHeading', 'lang' => $this->get( 'pageLanguage' ) ], $this->get( 'title' ) );


//////////
			$x = $this->getPortlet(
                                                                'namespaces',
                                                                $this->pileOfTools['namespaces'],
                                                                'timeless-namespaces'
                                                        );
			$html.= $x;
			$html.= $this->getPortlet('views', $this->pileOfTools['page-primary'], 'timeless-pagetools');
//////////


			$html.= '<div class="main-body-content-sub">';
			$html.= $this->getContentSub();
			$html.= '</div>';

			$html.= '<div class="main-body-content">';
			$html.= $this->get( 'bodytext' );
			$html.= '</div>';

		$html .= '</div>';
		$html .= '</div>';

		// $html .= Html::rawElement( 'div', [ 'id' => 'mw-content-container', 'class' => 'ts-container' ],
		// 	Html::rawElement( 'div', [ 'id' => 'mw-content-block', 'class' => 'ts-inner' ],
		// 		Html::rawElement( 'div', [ 'id' => 'mw-site-navigation' ],
		// 			$this->getSidebarChunk(
		// 				'site-tools',
		// 				'timeless-sitetools',
		// 				$this->getPortlet(
		// 					'tb',
		// 					$this->pileOfTools['general'],
		// 					'timeless-sitetools'
		// 				)
		// 			)
		// 		) .
		// 		Html::rawElement( 'div', [ 'id' => 'mw-content' ],
		// 			Html::rawElement( 'div', [ 'id' => 'content', 'class' => 'mw-body',  'role' => 'main' ],
		// 				$this->getSiteNotices() .
		// 				$this->getIndicators() .
		// 				Html::rawElement(
		// 					'h1',
		// 					[
		// 						'id' => 'firstHeading',
		// 						'class' => 'firstHeading',
		// 						'lang' => $this->get( 'pageLanguage' )
		// 					],
		// 					$this->get( 'title' )
		// 				) .
		// 				Html::rawElement( 'div', [ 'id' => 'mw-page-header-links' ],
		// 					$this->getPortlet(
		// 						'namespaces',
		// 						$this->pileOfTools['namespaces'],
		// 						'timeless-namespaces'
		// 					) .
		// 					$this->getPortlet(
		// 						'views',
		// 						$this->pileOfTools['page-primary'],
		// 						'timeless-pagetools'
		// 					)
		// 				) .
		// 				$this->getClear() .
		// 				Html::rawElement( 'div', [ 'class' => 'mw-body-content', 'id' => 'bodyContent' ],
		// 					$this->getContentSub() .
		// 					$this->get( 'bodytext' ) .
		// 					$this->getClear()
		// 				)
		// 			)
		// 		) .
		// 		$this->getAfterContent() .
		// 		$this->getClear()
		// 	)
		// );


		$html .= $this->getFooter();

		$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>';
		//$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js" integrity="sha256-vrn14y7WH7zgEElyQqm2uCGSQrX/xjYDjniRUQx3NyU=" crossorigin="anonymous"></script>';
		$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha256-fzFFyH01cBVPYzl16KT40wqjhgPtq6FFUB6ckN2+GGw=" crossorigin="anonymous"></script>';


		$html .= <<<EOS
<script>
$(function() {

	$(document).on('swipeLeft', function() {
		$('.main-menu').addClass('shut');
	});

	$(document).on('keydown', function(e) {
		switch (e.key) {
		case 'ArrowLeft':
			$('.main-menu').addClass('shut');
			break;
		case 'ArrowRight':
			$('.main-menu').removeClass('shut');
			break;
		}
		console.log(e);
	});

});
</script>
EOS;
		// BaseTemplate::printTrail() stuff (has no get version)
		// Required for RL to run
		// $html .= MWDebug::getDebugHTML( $this->getSkin()->getContext() );
		$html .= $this->get( 'bottomscripts' );
		//$html .= $this->get( 'reporttime' );

		$html .= Html::closeElement( 'body' );
		$html .= Html::closeElement( 'html' );

		// The unholy echo
		echo $html;
	}

	/**
	 * Generates a block of navigation links with a header
	 *
	 * @param string $name
	 * @param array|string $content array of links for use with makeListItem, or a block of text
	 *        Expected array format:
	 * 	[
	 * 		$name => [
	 * 			'links' => [ '0' =>
	 * 				[ 'href' => ..., 'single-id' => ..., 'text' => ... ]
	 * 			],
	 * 			'id' => ...,
	 * 			'active' => ...
	 * 		],
	 * 		...
	 * 	]
	 * @param null|string|array|bool $msg
	 *
	 * @return string html
	 * @since 1.29
	 */
	protected function getPortlet( $name, $content, $msg = null )
	{
		if ( $msg === null ) {
			$msg = $name;
		} elseif ( is_array( $msg ) ) {
			$msgString = array_shift( $msg );
			$msgParams = $msg;
			$msg = $msgString;
		}
		$msgObj = wfMessage( $msg );
		if ( $msgObj->exists() ) {
			if ( isset( $msgParams ) && !empty( $msgParams ) ) {
				$msgString = $this->getMsg( $msg, $msgParams )->parse();
			} else {
				$msgString = $msgObj->parse();
			}
		} else {
			$msgString = htmlspecialchars( $msg );
		}

		// HACK: Compatibility with extensions still using SkinTemplateToolboxEnd
		$hookContents = '';
		if ( $name == 'tb' ) {
			if ( isset( $boxes['TOOLBOX'] ) ) {
				ob_start();
				// We pass an extra 'true' at the end so extensions using BaseTemplateToolbox
				// can abort and avoid outputting double toolbox links
				// Avoid PHP 7.1 warning from passing $this by reference
				$template = $this;
				Hooks::run( 'SkinTemplateToolboxEnd', [ &$template, true ] );
				$hookContents = ob_get_contents();
				ob_end_clean();
				if ( !trim( $hookContents ) ) {
					$hookContents = '';
				}
			}
		}
		// END hack

		$labelId = Sanitizer::escapeId( "p-$name-label" );

		if ( is_array( $content ) ) {
			$contentText = Html::openElement( 'ul' );
			if ( $content !== [] ) {
				foreach ( $content as $key => $item ) {
					$contentText .= $this->makeListItem(
						$key,
						$item,
						[ 'text-wrapper' => [ 'tag' => 'span' ] ]
					);
				}
			}
			// Add in SkinTemplateToolboxEnd, if any
			$contentText .= $hookContents;
			$contentText .= Html::closeElement( 'ul' );
		} else {
			$contentText = $content;
		}

		$html = Html::rawElement( 'div', [
				'role' => 'navigation',
				'class' => [ 'mw-portlet', 'emptyPortlet' => !$content ],
				'id' => Sanitizer::escapeId( 'p-' . $name ),
				'title' => Linker::titleAttrib( 'p-' . $name ),
				'aria-labelledby' => $labelId
			],
			Html::rawElement( 'h3', [
					'id' => $labelId,
					'lang' => $this->get( 'userlang' ),
					'dir' => $this->get( 'dir' )
				],
				$msgString
			) .
			Html::rawElement( 'div', [ 'class' => 'mw-portlet-body' ],
				$contentText .
				$this->getAfterPortlet( $name )
			)
		);

		return $html;
	}

	/**
	 * Sidebar chunk containing one or more portlets
	 *
	 * @param string $id
	 * @param string $headerMessage
	 * @param string $content
	 *
	 * @return string html
	 */
	protected function getSidebarChunk( $id, $headerMessage, $content ) {
		$html = '';

		$html .= Html::rawElement(
			'div',
			[ 'id' => Sanitizer::escapeId( $id ), 'class' => 'sidebar-chunk' ],
			Html::rawElement( 'div', [ 'class' => 'sidebar-inner' ], $content )
		);

		return $html;
	}

	/**
	 * The logo and (optionally) site title
	 *
	 * @param string $id
	 * @param string $part whether it's only image, only text, or both
	 *
	 * @return string html
	 */
	protected function getLogo( $id = 'p-logo', $part = 'both' ) {
		$html = '';
		$language = $this->getSkin()->getLanguage();

		$html .= Html::openElement(
			'div',
			[
				'id' => Sanitizer::escapeId( $id ),
				'class' => 'mw-portlet',
				'role' => 'banner'
			]
		);
		if ( $part !== 'image' ) {
			$titleClass = '';
			if ( $language->hasVariants() ) {
				$siteTitle = $language->convert( $this->getMsg( 'timeless-sitetitle' )->text() );
			} else {
				$siteTitle = $this->getMsg( 'timeless-sitetitle' )->text();
			}
			// width is 11em; 13 characters will probably fit?
			if ( mb_strlen( $siteTitle ) > 13 ) {
				$titleClass = 'long';
			}
			$html .= Html::element( 'a', [
					'id' => 'p-banner',
					'class' => [ 'mw-wiki-title', $titleClass ],
					'href' => $this->data['nav_urls']['mainpage']['href']
				],
				$siteTitle
			);
		}
		if ( $part !== 'text' ) {
			$html .= Html::element( 'a', array_merge(
				[
					'class' => 'mw-wiki-logo',
					'href' => $this->data['nav_urls']['mainpage']['href']
				],
				Linker::tooltipAndAccesskeyAttribs( 'p-logo' )
			) );
		}
		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Left sidebar navigation, usually
	 *
	 * @return string html
	 */
	protected function getMainNavigation() {
		$sidebar = $this->getSidebar();
		$html = '';

		// Already hardcoded into header
		$sidebar['SEARCH'] = false;
		// Parsed as part of pageTools
		$sidebar['TOOLBOX'] = false;
		// Forcibly removed to separate chunk
		$sidebar['LANGUAGES'] = false;

		foreach ( $sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;
			$html .= $this->getPortlet( $name, $content['content'] );
		}

		$html = $this->getSidebarChunk( 'site-navigation', 'navigation', $html );

		return $html;
	}

	/**
	 * Page tools in sidebar
	 *
	 * @return string html
	 */
	protected function getPageToolSidebar() {
		$pageTools = '';
		$pageTools .= $this->getPortlet(
			'cactions',
			$this->pileOfTools['page-secondary'],
			'timeless-pageactions'
		);
		$pageTools .= $this->getPortlet(
			'userpagetools',
			$this->pileOfTools['user'],
			'timeless-userpagetools'
		);
		$pageTools .= $this->getPortlet(
			'pagemisc',
			$this->pileOfTools['page-tertiary'],
			'timeless-pagemisc'
		);

		return $this->getSidebarChunk( 'page-tools', 'timeless-pageactions', $pageTools );
	}

	/**
	 * Personal/user links portlet for header
	 *
	 * @return array [ html, class ], where class is an extra class to apply to surrounding objects
	 * (for width adjustments)
	 */
	protected function getUserLinks() {
		$user = $this->getSkin()->getUser();
		$personalTools = $this->getPersonalTools();

		$html = '';
		$extraTools = [];

		// Remove Echo badges
		if ( isset( $personalTools['notifications-alert'] ) ) {
			$extraTools['notifications-alert'] = $personalTools['notifications-alert'];
			unset( $personalTools['notifications-alert'] );
		}
		if ( isset( $personalTools['notifications-notice'] ) ) {
			$extraTools['notifications-notice'] = $personalTools['notifications-notice'];
			unset( $personalTools['notifications-notice'] );
		}
		$class = empty( $extraTools ) ? '' : 'extension-icons';

		// Re-label some messages
		if ( isset( $personalTools['userpage'] ) ) {
			$personalTools['userpage']['links'][0]['text'] = $this->getMsg( 'timeless-userpage' )->text();
		}
		if ( isset( $personalTools['mytalk'] ) ) {
			$personalTools['mytalk']['links'][0]['text'] = $this->getMsg( 'timeless-talkpage' )->text();
		}

		// Labels
		if ( $user->isLoggedIn() ) {
			$userName = $user->getName();
			// Make sure it fits first (numbers slightly made up, may need adjusting)
			$fit = empty( $extraTools ) ? 13 : 9;
			if ( mb_strlen( $userName ) < $fit ) {
				$dropdownHeader = $userName;
			} else {
				$dropdownHeader = wfMessage( 'timeless-loggedin' )->text();
			}
			$headerMsg = [ 'timeless-loggedinas', $user->getName() ];
		} else {
			$dropdownHeader = wfMessage( 'timeless-anonymous' )->text();
			$headerMsg = 'timeless-notloggedin';
		}
		$html .= Html::openElement( 'div', [ 'id' => 'user-tools' ] );

		$html .= Html::rawElement( 'div', [ 'id' => 'personal' ],
			Html::rawElement( 'h2', [],
				Html::element( 'span', [], $dropdownHeader ) .
				Html::element( 'div', [ 'class' => 'pokey' ] )
			) .
			Html::rawElement( 'div', [ 'id' => 'personal-inner', 'class' => 'dropdown' ],
				$this->getPortlet( 'personal', $personalTools, $headerMsg )
			)
		);

		// Extra icon stuff (echo etc)
		if ( !empty( $extraTools ) ) {
			$iconList = '';
			foreach ( $extraTools as $key => $item ) {
				$iconList .= $this->makeListItem( $key, $item );
			}

			$html .= Html::rawElement(
				'div',
				[ 'id' => 'personal-extra', 'class' => 'p-body' ],
				Html::rawElement( 'ul', [], $iconList )
			);
		}

		$html .= Html::closeElement( 'div' );

		return [
			'html' => $html,
			'class' => $class
		];
	}

	/**
	 * Notices that may appear above the firstHeading
	 *
	 * @return string html
	 */
	protected function getSiteNotices() {
		$html = '';

		if ( $this->data['sitenotice'] ) {
			$html .= Html::rawElement( 'div', [ 'id' => 'siteNotice' ], $this->get( 'sitenotice' ) );
		}
		if ( $this->data['newtalk'] ) {
			$html .= Html::rawElement( 'div', [ 'class' => 'usermessage' ], $this->get( 'newtalk' ) );
		}

		return $html;
	}

	/**
	 * Links and information that may appear below the firstHeading
	 *
	 * @return string html
	 */
	protected function getContentSub() {
		$html = '';

		$html .= Html::openElement( 'div', [ 'id' => 'contentSub' ] );
		if ( $this->data['subtitle'] ) {
			$html .= $this->get( 'subtitle' );
		}
		if ( $this->data['undelete'] ) {
			$html .= $this->get( 'undelete' );
		}
		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * The data after content, catlinks, and potential other stuff that may appear within
	 * the content block but after the main content
	 *
	 * @return string html
	 */
	protected function getAfterContent() {
		$html = '';

		if ( $this->data['catlinks'] || $this->data['dataAfterContent'] ) {
			$html .= Html::openElement( 'div', [ 'id' => 'content-bottom-stuff' ] );
			if ( $this->data['catlinks'] ) {
				$html .= $this->get( 'catlinks' );
			}
			if ( $this->data['dataAfterContent'] ) {
				$html .= $this->get( 'dataAfterContent' );
			}
			$html .= Html::closeElement( 'div' );
		}

		return $html;
	}

	/**
	 * Generate pile of all the tools
	 *
	 * We can make a few assumptions based on where a tool started out:
	 *     If it's in the cactions region, it's a page tool, probably primary or secondary
	 *     ...that's all I can think of
	 *
	 * @return array of array of tools information (portlet formatting)
	 */
	protected function getPageTools() {
		$title = $this->getSkin()->getTitle();
		$namespace = $title->getNamespace();

		$sortedPileOfTools = [
			'namespaces' => [],
			'page-primary' => [],
			'page-secondary' => [],
			'user' => [],
			'page-tertiary' => [],
			'general' => []
		];

		// Tools specific to the page
		$pileOfEditTools = [];
		foreach ( $this->data['content_navigation'] as $navKey => $navBlock ) {
			// Just use namespaces items as they are
			if ( $navKey == 'namespaces' ) {
				if ( $namespace < 0 ) {
					// Put special page ns_pages in the more pile so they're not so lonely
					$sortedPileOfTools['page-tertiary'] = $navBlock;
				} else {
					$sortedPileOfTools['namespaces'] = $navBlock;
				}
			} else {
				$pileOfEditTools = array_merge( $pileOfEditTools, $navBlock );
			}
		}

		// Tools that may be general or page-related (typically the toolbox)
		$pileOfTools = $this->getToolbox();
		if ( $namespace >= 0 ) {
			$pileOfTools['pagelog'] = [
				'text' => 'POT-PAGE-LOG', // $this->getMsg( 'timeless-pagelog' )->text(),
				'href' => SpecialPage::getTitleFor( 'Log', $title->getPrefixedText() )->getLocalURL(),
				'id' => 't-pagelog'
			];
		}
		$pileOfTools['more'] = [
			'text' => 'POT-MORE', // $this->getMsg( 'timeless-more' )->text(),
			'id' => 'ca-more',
			'class' => 'dropdown-toggle'
		];

		// Goes in the page-primary in mobile, doesn't appear otherwise
		if ( $this->data['language_urls'] !== false ) {
			$pileOfTools['languages'] = [
				'text' => $this->getMsg( 'timeless-languages' )->escaped(),
				'id' => 'ca-languages',
				'class' => 'dropdown-toggle'
			];
		}

		// This is really dumb, and you're an idiot for doing it this way.
		// Obviously if you're not the idiot who did this, I don't mean you.
		foreach ( $pileOfEditTools as $navKey => $navBlock ) {
			$currentSet = null;

			if ( in_array( $navKey, [
				'watch',
				'unwatch'
			] ) ) {
				$currentSet = 'namespaces';
			} elseif ( in_array( $navKey, [
				'edit',
				'view',
				'history',
				'addsection',
				'viewsource'
			] ) ) {
				$currentSet = 'page-primary';
			} elseif ( in_array( $navKey, [
				'delete',
				'rename',
				'protect',
				'unprotect',
				'move'
			] ) ) {
				$currentSet = 'page-secondary';
			} else {
				// Catch random extension ones?
				$currentSet = 'page-primary';
			}
			$sortedPileOfTools[$currentSet][$navKey] = $navBlock;
		}
		foreach ( $pileOfTools as $navKey => $navBlock ) {
			$currentSet = null;

			if ( in_array( $navKey, [
				'contributions',
				'more',
				'languages'
			] ) ) {
				$currentSet = 'page-primary';
			} elseif ( in_array( $navKey, [
				'blockip',
				'userrights',
				'log'
			] ) ) {
				$currentSet = 'user';
			} elseif ( in_array( $navKey, [
				'whatlinkshere',
				'print',
				'info',
				'pagelog',
				'recentchangeslinked',
				'permalink'
			] ) ) {
				$currentSet = 'page-tertiary';
			} else {
				$currentSet = 'general';
			}
			$sortedPileOfTools[$currentSet][$navKey] = $navBlock;
		}

		return $sortedPileOfTools;
	}

	/**
	 * Categories for the sidebar
	 *
	 * Assemble an array of categories, regardless of view mode. Just using Skin or
	 * OutputPage functions doesn't respect view modes (preview, history, whatever)
	 * But why? I have no idea what the purpose of this is.
	 *
	 * @return string html
	 */
	protected function getCategories() {
		global $wgContLang;

		$skin = $this->getSkin();
		$title = $skin->getTitle();
		$catList = false;
		$html = '';

		// Get list from outputpage if in preview; otherwise get list from title
		if ( in_array( $skin->getRequest()->getVal( 'action' ), [ 'submit', 'edit' ] ) ) {
			$allCats = [];
			// Can't just use getCategoryLinks because there's no equivalent for Title
			$allCats2 = $skin->getOutput()->getCategories();
			foreach ( $allCats2 as $displayName ) {
				$catTitle = Title::makeTitleSafe( NS_CATEGORY, $displayName );
				$allCats[] = $catTitle->getDBkey();
			}
		} else {
			// This is probably to trim out some excessive stuff. Unless I was just high on cough syrup.
			$allCats = array_keys( $title->getParentCategories() );

			$len = strlen( $wgContLang->getNsText( NS_CATEGORY ) . ':' );
			foreach ( $allCats as $i => $catName ) {
				$allCats[$i] = substr( $catName, $len );
			}
		}
		if ( $allCats !== [] ) {
			$dbr = wfGetDB( DB_REPLICA );
			$res = $dbr->select(
				[ 'page', 'page_props' ],
				[ 'page_id', 'page_title' ],
				[
					'page_title' => $allCats,
					'page_namespace' => NS_CATEGORY,
					'pp_propname' => 'hiddencat'
				],
				__METHOD__,
				[],
				[ 'page_props' => [ 'JOIN', 'pp_page = page_id' ] ]
			);
			$hiddenCats = [];
			foreach ( $res as $row ) {
				$hiddenCats[] = $row->page_title;
			}
			$normalCats = array_diff( $allCats, $hiddenCats );

			$normalCount = count( $normalCats );
			$hiddenCount = count( $hiddenCats );
			$count = $normalCount;

			// Mostly consistent with how Skin does it.
			// Doesn't have the classes. Either way can't be good for caching.
			if (
				$skin->getUser()->getBoolOption( 'showhiddencats' ) ||
				$title->getNamespace() == NS_CATEGORY
			) {
				$count += $hiddenCount;
			} else {
				/* We don't care if there are hidden ones. */
				$hiddenCount = 0;
			}

			// Assemble the html...
			if ( $count ) {
				if ( $normalCount ) {
					$catHeader = 'categories';
				} else {
					$catHeader = 'hidden-categories';
				}
				$catList = '';
				if ( $normalCount ) {
					$catList .= $this->getCatList( $normalCats, 'catlist-normal', 'categories' );
				}
				if ( $hiddenCount ) {
					$catList .= $this->getCatList(
						$hiddenCats,
						'catlist-hidden',
						[ 'hidden-categories', $hiddenCount ]
					);
				}
			}
		}
		if ( $catList ) {
			$html = $this->getSidebarChunk( 'catlinks-sidebar', $catHeader, $catList );
		}

		return $html;
	}

	/**
	 * List of categories
	 *
	 * @param array $list
	 * @param string $id
	 * @param string|array $message i18n message name or an array of [ message name, params ]
	 *
	 * @return string html
	 */
	protected function getCatList( $list, $id, $message ) {
		$html = '';

		$categories = [];
		// Generate portlet content
		foreach ( $list as $category ) {
			$title = Title::makeTitleSafe( NS_CATEGORY, $category );
			if ( !$title ) {
				continue;
			}
			$categories[ htmlspecialchars( $category ) ] = [ 'links' => [ 0 => [
				'href' => $title->getLinkURL(),
				'text' => $title->getText()
			] ] ];
		}

		$html .= $this->getPortlet( $id, $categories, $message );

		return $html;
	}

	/**
	 * Interlanguage links block, also with variants
	 *
	 * @return string html
	 */
	protected function getInterlanguageLinks() {
		$html = '';

		if ( isset( $this->data['variant_urls'] ) && $this->data['variant_urls'] !== false ) {
			$variants = $this->getPortlet( 'variants', $this->data['variant_urls'], true );
		} else {
			$variants = '';
		}
		if ( $this->data['language_urls'] !== false ) {
			$html .= $this->getSidebarChunk(
				'other-languages',
				'timeless-languages',
				$variants .
				$this->getPortlet(
					'lang',
					$this->data['language_urls'] ?: [],
					'otherlanguages'
				)
			);
		}

		return $html;
	}

	function getMenuZeroSearch()
	{
		$html = '<form action="/index.php" id="searchform">';
		$html .= '<input type="hidden" value="Special:Search" name="title">';
		$html .= '<div class="input-group">';
		$html .= '<input class="form-control" type="search" name="search" placeholder="Search" title="Search OpenTHC [f]" accesskey="f" id="searchInput">';
		$html .= '<div class="input-group-append"><button class="btn btn-outline-success" type="submit">Search</button></div>';
		//$html .= '<input type="submit" name="fulltext" value="Search" title="Search the pages for this text" class="searchButton mw-fallbackSearchButton">';
		//$html .= '<input type="submit" name="go" value="Go" title="Go to a page with this exact name if it exists" id="searchButton" class="searchButton">';
		$html .= '</div>';
		$html .= '</form>';

		return $html;
	}


	function getMenuZeroSecondary()
	{
		$user = $this->getSkin()->getUser();
		$personalTools = $this->getPersonalTools();

		$html = '<ul class="navbar-nav ml-auto">';

		if (!$user->isLoggedIn()) {
			$returnto = '';
			$link = SkinOpenTHC::makeSpecialUrl( 'Userlogin', $returnto );
			$html.= '<li class="nav-item"><a class="nav-link" href="' . $link . '"><i class="fa fa-sign-in" style="color:#409E40;"></i></a></li>';
		} else {
			// Real User
		}

		$html .= '</ul>';

		return $html;
	}


	function getFooter($iconStyle = 'icononly', $linkStyle = 'flat')
	{
		$foot_link = array();
		$validFooterLinks = $this->getFooterLinks( 'flat' );
		//$validFooterLinks = array();
		if ( count( $validFooterLinks ) > 0 ) {
			//$foot .= Html::openElement( 'ul', [ 'id' => 'f-list', 'class' => 'footer-places' ] );
			foreach ( $validFooterLinks as $aLink ) {
				$foot_link[] = Html::rawElement(
					'div',
					[ 'id' => Sanitizer::escapeIdForAttribute( $aLink ), 'class' => 'flex-fill' ],
					$this->get( $aLink )
				);
			}
			//$foot .= Html::closeElement( 'ul' );
		}

		//$foot_link = implode('', $foot_link);
		$foot_link = null;

		$foot = <<<EOF
<footer class="page-footer">
<div class="container-fluid">
<div class="row">

<div class="col-sm-4">
	<ul>
	<li><a href="https://openthc.com">OpenTHC</a></li>
	<li><a href="https://directory.openthc.com">Directory</a></li>
	<li><a href="https://qa.openthc.org">QA</a></li>
	<!--
	<li><a href="https://menu.openthc.com">Menu</a></li>
	-->
	</ul>
</div>
<div class="col-sm-4">
	<ul>
	<li><a href="https://openthc.com/sop" title="Standard Operating Procedures">SOP</a></li>
	<li><a href="https://sdb.openthc.org/">Strains</a></li>
	<li><a href="https://data.openthc.org">Data</a></li>
	</ul>
</div>
<div class="col-sm-4">
	<ul>
	<li><a href="https://twitter.com/openthc"><i class="fa fa-twitter"></i></a></li>
	<li><a href="https://instagram.com/openthc"><i class="fa fa-instagram"></i></a></li>
	<li><a href="https://github.com/openthc"><i class="fa fa-github"></i></a></li>
	</ul>
</div>

</div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<div class="d-flex">
	$foot_link
</div>

<div style="background: #333; margin:0; padding:1em;">
	<p style="color: #f0f0f0; margin:0; padding:0; text-align:center;">All materials © OpenTHC 2014-2018</p>
</div>

</footer>
EOF;

		return $foot;
	}
}
