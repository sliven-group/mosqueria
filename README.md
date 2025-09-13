# WordPress Theme README

## Overview

### Theme Description

## Key Features

### Theme Development and Customization

#### Developing with Webpack

- Modify the **webpack.mix.js** file. Change the value of the browserSync proxy to the domain assigned to the project in your virtual host. Example:

```javascript
mix.browserSync({
	proxy: 'local.mosqueriawp.com',
});
```

- Ensure that Node.js/npm is installed.
  - To install these two packages:
    - [Node.js](https://nodejs.org/es/) - Version 18 and above.
    - [NPM](https://yarnpkg.com/) - Version 9 and above.
- Open a terminal in **/wp-content/themes/wordpress-skeleton/** and execute the following commands:
  `npm i`
- Run the initial build of CSS and JS files for production with the following command in the same terminal as before:
  `npm run production`
- The above command will have created the CSS and JS files in a folder at **/wp-content/themes/wordpress-skeleton/assets** (the development version of this folder will not be versioned).
- In the same terminal as before, located in **/wp-content/themes/wordpress-skeleton/** run:
  `npm run watch`
- The above command will perform all configured automatic tasks and open a new browser window with WordPress. Note that the URL provided will be **http://localhost:3000**. This URL can be used to view real-time changes made in the code. Additionally, the URL configured in your virtual host will also be accessible, although you will need to manually refresh it each time you want to see a change.

#### Integrating Linter Tools

- We are using ESLint and Prettier as linter tools, and the configurations can be found in the files **.eslintrc.json** and **.prettierrc**
- For a smoother experience, install ESLint and Prettier extensions in your editor (e.g., VSCode). Ensure to enable the "Format on Save" option so that Prettier automatically formats your code upon saving.

### Setup and Configuration

#### Advanced Theme Options and Administration

- First, you need to register the general options; this is recorded in **inc/custom_fields/settings.php** to add fields within the options, you must create custom fields and register them in **inc/custom_fields/acf_settings.php**.

##### Customizing Header and Dynamic Menus

- The structure of the header is located in the file **header.php**. The function **has_nav_menu** is called, and you need to pass the identifier registered in the file **/inc/ws.php**. To create the menu, you would need to go to the administrator at **local.wordpress-skeleton.com/wp-admin/nav-menus.php**, create the menu, and add the pages to it.

##### Tailoring the Footer

- The structure of the footer is located in the file **footer.php**. The function **wp_nav_menu** is called, and you need to pass the identifier registered in the file **/inc/ws.php**. Additionally, the function**get_field** is used to fetch dynamic ACF data.

##### Script Integration within Theme Options

- To add additional scripts, both in the head and footer, you would need to go to the administrator at **local.wordpress-skeleton.com/wp-admin/admin.php?page=theme-general-settings**. There are two fields available to add the scripts.

#### Advanced Custom Fields (ACF) Customization

- Installation and Activation of Advanced Custom Fields:
  - Install the ACF plugin from the WordPress Repository or by uploading files.
  - Activate the plugin.
- Create a Field Group for Your ACF Block:
  - In the WordPress admin panel, go to "Custom Fields" and click on "Add New" to create a new field group.
  - Assign a descriptive name to the group and click on "Add Field" to add the fields you need.
- Data export:
  - Go to **menu ACF->tools** select the field groups you want to export and click the button to generate php.
  - Go to **/inc/custom_fields** and create a php file with a name related to the block or custom field always using the **acf\_** prefix.
  - Delete fields created in ACF menu.

##### Creating Custom ACF Blocks

- To create a block, you first need to create the file structure in **inc/blocks/your-block-name/**. Within that folder, there should be two files: **your-block-name.php** and **block.json** Afterward, you have to register that block in **inc/ws.php** in the **register_acf_blocks** function. Inside the **$blocks** array, add the name of the .php file.

##### Implementing and Customizing Child Blocks

- First, go to "Custom Fields" in the admin panel and create a new field group for your parent block. Add the necessary fields.
- In the same field group, go to the "Location" tab and choose "Block" in the location rule. Specify the name of the parent block or select "All" if you want this group to apply to all blocks.
- Now, create a second field group for your child block. This group should contain fields specific to the child block.
- Create the structure for the parent and child blocks in **inc/blocks/**.
- Register the parent and child blocks in **inc/ws.php** in the **register_acf_blocks** function.

##### Dynamic Style Loading for Blocks

- To add styles to the blocks, you should go to **inc/ws.php** and use the **register_acf_blocks_assets** function. You need to perform a validation with the block name and register the corresponding CSS and JS files.

#### Content Management Development

- To create a custom post type and custom taxonomy, you can utilize the folders **inc/custom_posts** and **inc/custom_taxonomy**. It's recommended to use the prefixes "post-" for post types and "taxonomy-" for taxonomies.

##### Customizing the Login Screen

- To customize the CSS of the login page, you can do so from **administrator/css/login.css**. For customizing text, use **inc/actions/login-custom.php**.

##### Developing Standard WordPress Pages

- Templates to customize 404 pages are in **404.php**, for default pages use **page.php** for search page use **search.php**, for single post use **single.php** and for custom templates, you can look in the **/templates** directory.

##### Required plugins

- To add plugins that are essential for the theme, go to **inc/actions/class-register-plugins.php** in the **$plugins** array and add the values ​​corresponding to the plugin you want to add, if the plugin is from payment you would have to add the zip file to the **plugins** folder.

### Accessibility and SEO Optimization in Development

## Advanced Development Features

### Continuous Integration and Deployment

- Extensive CI/CD guides for developers using GitHub + AWS and GitLab + AWS.

#### CI/CD Integration with GitHub and AWS

- Detailed setup process and best practices.

#### CI/CD Integration with GitLab and AWS

- Step-by-step guide for GitLab and AWS integration.

### Performance and SEO Strategies in Theme Development

- Tips and techniques for optimizing theme performance and SEO.

## Getting Started with Development

### Installation and Setup for Developers

### Detailed Configuration Guide

## Usage and Customization

### Guidelines for Theme Customization and Extension

### Content Management and Advanced Features

## Additional Resources and Developer Documentation

_Note: Each section should be elaborated with comprehensive instructions, code snippets, and examples to assist developers in customizing and enhancing the theme._

```

```
