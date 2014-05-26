**1.4.2**
* **Fix** Handled dependency from SitePress::get_setting()
* **Fix** Updated translations

**1.4.1**
* **Performances**: Reduced the number of calls to *$sitepress->get_current_language()*, *$this->get_active_languages()* and *$this->get_default_language()*, to avoid running the same queries more times than needed
* **Feature** Added WPML capabilities (see online documentation)
* **Fix** Using CMS Nav in a non content page (e.g. a static page that only calls wp_head()), won't cause any warning because the $post object is null.
* **Fix** When HTTP_USER_AGENT is not set it won't cause any error