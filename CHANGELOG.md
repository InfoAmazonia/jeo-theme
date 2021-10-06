# JEO Theme - CHANGELOG
## v1.5.0

CHANGES:

- fix: using get_author_meta() function to get user description with translations if exists
- fix header erros when using short header config
- NEW FEATURE: add customizer checkbox to enable/disable dark theme/dark-mode
- remove the author from the Yoast SEO schema if it is not listed
- fix embed on safari
- fix cron meta setting author meta empty
- fix mobile cards
- display language name on WPML button
- add feature image description
- fix duplicated header moda on ipad


## v1.4.0
Minor fixes

- Show only 3 related posts
- Fix in request to image-gallery.js to avoid error console

## v1.3.1
**Features**
- [ Gutenberg ] Include “Credited Image”, “Image Gallery” and “Video gallery” in Media category #435
- [ Media Partners Archive ] Make that media partners archive uses archive.php (used in category/tags) #429
- [ Latest Post Block ] Adjust css #441
- [ Homepage posts ] Remove type icon in fullwidth mode #431

**Fixes**
- [ Discovery Page ] Reduce z-index for share-button #433
- [ Story Maps ] Fix in storymap's archive to has category/tags's archive layout #428
- [ Infoamazonia Prod Env ] Validate missing media (HTMLs, images) #438

## v1.3.0

Major features
- Site optimization
- Internationalization for *.js

Minor fixes
- Fix in "External source link" field when URS has special characters 

## v1.2.1
**Minor features**
- [ Media Partner / External Link] External Link use'Media Partner' instead of 'original publisher name' 
- [ Breadscrumbs ] Keep breadscrumbs active (for structured data) but hide them in all front-end pages

**Fixes**
- Interationalization files (*.pot)
- [ Map embed ] cookies banner mustn't appear on embed map
- [Image Gallery] Photo must include caption / description as credited image block does

## v1.2.0

*New features*
- [ Author Page ] If author's name doesn't appear on the top of the post, the post shouldn't be listed in author's page
- [ Video URL to share ] New format 
- [Image Gallery] Drag and Drop photos in Editor. Add degrade in mobile
 - [ Post Configuration ] Add checkbox to hide/show excerpt in post
- [ See more posts ] The "Load more posts" home resource should follow the same style created for the "See more <something>"
- [ Featured image ] Large and Small featured image must include description/credit as credit image block
- [ Cookies banner ] New cookie banner location
- [ Copyright ] Add hacklab and jeo theme's logo below main footer
- [ Special Project ] Add authors list as any post (using Multiple author plugin) 
- [ Team block ] Make the team block in Post Editor more similar to team block in Front End 

*Minor fixes*
- Fixes[ Validations ] categories in Related posts
- [ Author Page ] Layout is not showing social networks and image is too large 
- [ Most Read Widget ] Fix and Remove author (by <author>) and add post's date in Most Read widget
- [ MediaPartner and Author in Post ] 
- [ Archive Page ] Show icons according to type category (audio, video, map)
- [ Customize Panel ] The main description of special projects page must be translatable
- [ Auto fill ] Support to AutoFill in email field for newsletter and comments
- [ Most read ] Consider posts where author is not 1st author.
- [ Published Post ] If post doesn't have primary category anymore, old primary category still appears
- [ Post Template ] Audio and Featured Image
- [ Credited Image block ] This block must use 'credit' and 'description/caption' fields of image

## v1.1.0
**New features**
- New template for maps
- Use tags instead of topic category

**Minor fixes**
- Validation if 'partner' taxonomy exists
- Author's checkboxes: show/hide author listing / author biography in post

## v1.0.0
**New Features**
- Publishers using Media Partners
- Story Map's styles (using JEO Plugin)
- Discovery 's styles (using JEO Plugin)
- New checkbox "republish link in all post" was added (only for new posts)
- Content box: title as text field
- Sorry section: new tooltip
- Yoast breadcrumbs according to jeo theme's style

**Minor fixes**
- Image Gallery - fixes in responsive mode
- Related posts - audio/video/opinion's hardcode ids were removed 
- Safari compatibiliy fixes
- Pasifika'css for newsletter was removed
- Sorry section: after clicking on alert icon, the sorry section appears in the screen correctly
- Dark mode fixes

## v0.3.1
**Major fixes**
- Correct slug according to selected language (WPML)

**Minor fixes - templates/css**
- Category Page
- Author Page
- Dark mode
- JEO Plugin css was removed from jeo-theme
- Menu

**Minor fixes - Gutenberg blocks**
- Alignment for credited image block
- handle error in Tooltip feature

## v0.3.0

**Features**<br>

**Customize Panel:**
- New field for typography to titles in Home, Post, Category, Tags, Author and Search Page.
- Custom color for decorative bar (Ex. element next to category name)
- Republish modal configuration: title, main introductory text, introductory text for bullets
- Project List: introductory text 
- Content box: title

**Widgets**
- Republish modal's bullets are configured in Widgets section
- A bullet is created as "bullet widget" inside of "Bullets widget area"

**Post Editor Page**
- Option to hide/show republish link post
- Option to hide/show list of authors (by author name1, author name 2..)
- Option to hide/show authors' biography

**Special Project**
- Special Project Page
- Special Project List Page

**Gutenberg blocks**
- New Gutenberg block: Context box
- New Gutenberg block: Team and team member
- New Gutenberg block: Dropdown links
- Tooltip option added in Paragraph Gutenberg block

**Other features**
- Post's thumbnail with icon in right bottom corner if post's category type is "audio", "video" or "map"
- New style for "we said sorry" block
- New style for main audio and secundary audio in Audio Post.

**Fixes**
- Minor fixes for Responsive mode
- Minor fixes for
 Dark mode
- Minor fixes in iPhone / iPad
- Horizontal scroll for image gallery in mobile
- External link icon appears even if post thumbnail doesn't have metadata (ex. date and hour)

## v0.2.1

Minor fixes in CSS for:
- cookies banner in mobile
- switcher language in mobile
- font-size in homepage post block when is used in posts
- new styles for Sorry Block in posts

## v0.2.0

About: JEO Theme is based on Scott theme which is a child-theme of Newspack-theme
<br><br>

Required parent theme:<br>
Newspack-theme v1.14.0<br>
https://github.com/Automattic/newspack-theme/releases/tag/v1.14.0

<br><br>
Required plugins:<br>
Newspack-plugin v1.18.0<br>
https://github.com/Automattic/newspack-plugin/releases/tag/v1.18.0

<br>
Features
- Video Gallery Component
- Multselect filters in Search Page
- Alert after deleting categories in Dashboard
- Update Opinion Post
- Font-size for heading mobile
- Improvements in Post's comment form 
- Share by Twitter (author's twitter are added in tweet)
- Share by Twitter (Video Post with player card)
- RSS tested with Flipboard and Feedly
- Open Graph for multiauthors
- Minor fixes in css / layout / mobile / dark mode
<br><br>
## v0.1.0
**About:** JEO Theme is based on Scott theme which is a child-theme of Newspack-theme
**Required parent theme:**
Newspack-theme v1.11.1<br>
https://github.com/Automattic/newspack-theme/releases/tag/v1.11.1

**Required plugins:**
Newspack-plugin v1.12.0<br>
https://github.com/Automattic/newspack-plugin/releases/tag/v1.12.0<br>
These plugins are pre-installed by newspack-plugin
- WP Avatar
- Co authors
- Newspack blocks
- Newspack Image credits
- Yoast
- MC4WP: Mailchimp for WordPress

Other plugins:
- Safe SVG
- Google Analytics
- Disable Big Image Threshold

**This deliverable includes:**
- Theme configuration in Customize Page
- Home Page styles
- Post Configuration: show author, show sorry block, categories
- New Gutenberg blocks: Credited image block
- Post  with credited featured image behind the title
- Post Special: Image Gallery, Audio
- Post Special: Video,
- Post Special: Opinion 
- Category / Tag Page 
- About Us Page
- Search Page
- Author Page 
- 1st version of mobile pages. 

**How admin must create categories/topics/regions**
Create this category's structure with these exact slugs
**category: type**
subcategories
- audio
- image gallery
- opinion
- video

**category: topic**
subcategories: any

**For each post, user must select**
type / topic
select as primary category: selected topic

