<?php
/*
Plugin Name: Book Library Management
Description: A simple book library management plugin.
Version: 1.0
Author: Habiba
*/

if (!defined('ABSPATH')) {
    exit;
}


/* Admin Menu */
function book_library_menu() {

    add_menu_page(
        'Book Library',
        'Book Library',
        'manage_options',
        'book-library',
        'book_library_page',
        'dashicons-book',
        25
    );
}

add_action('admin_menu', 'book_library_menu');


/* Book Library Page */
function book_library_page() {

    $books = get_option('book_library_books', array());


    /* Delete Book */
    if (isset($_POST['delete_book'])) {

        $delete_index = intval($_POST['delete_book']);

        if (isset($books[$delete_index])) {

            unset($books[$delete_index]);

            $books = array_values($books);

            update_option('book_library_books', $books);

            echo '<div class="notice notice-success is-dismissible">
                    <p>Book deleted successfully!</p>
                  </div>';
        }
    }


    /* Add Book */
    if (isset($_POST['add_book'])) {

        $title = sanitize_text_field($_POST['book_title']);
        $author = sanitize_text_field($_POST['book_author']);
        $category = sanitize_text_field($_POST['book_category']);
        $year = sanitize_text_field($_POST['book_year']);

        $books[] = array(
            'title' => $title,
            'author' => $author,
            'category' => $category,
            'year' => $year
        );

        update_option('book_library_books', $books);

        echo '<div class="notice notice-success is-dismissible">
                <p>Book added successfully!</p>
              </div>';
    }


    /* Update Book */
    if (isset($_POST['update_book'])) {

        $edit_index = intval($_POST['edit_index']);

        if (isset($books[$edit_index])) {

            $books[$edit_index]['title'] =
                sanitize_text_field($_POST['edit_title']);

            $books[$edit_index]['author'] =
                sanitize_text_field($_POST['edit_author']);

            $books[$edit_index]['category'] =
                sanitize_text_field($_POST['edit_category']);

            $books[$edit_index]['year'] =
                sanitize_text_field($_POST['edit_year']);

            update_option('book_library_books', $books);

            echo '<div class="notice notice-success is-dismissible">
                    <p>Book updated successfully!</p>
                  </div>';
        }
    }


    /* Edit Book */
    $edit_index = -1;

    if (isset($_GET['edit_book'])) {
        $edit_index = intval($_GET['edit_book']);
    }

    ?>

    <style>

        /* Main Container */

        .book-library-container {
            max-width: 1100px;
            margin: 30px auto;
        }


        /* Main Heading */

        .book-library-container h1 {
            font-size: 32px;
            margin-bottom: 25px;
        }


        /* Section Heading */

        .book-library-container h2 {
            font-size: 22px;
            margin-top: 25px;
            margin-bottom: 15px;
        }


        /* Form */

        .book-library-form {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }


        /* Input Fields */

        .book-library-form input[type="text"],
        .book-library-form input[type="number"] {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }


        /* Add and Update Button */

        .book-library-form input[type="submit"] {
            background: #2271b1;
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 6px;
            cursor: pointer;
        }


        .book-library-form input[type="submit"]:hover {
            background: #135e96;
        }


        /* Books Table */

        .book-library-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }


        /* Table Header */

        .book-library-table th {
            background: #2271b1;
            color: white;
            padding: 14px;
            text-align: left;
        }


        /* Table Cells */

        .book-library-table td {
            padding: 13px;
            border-bottom: 1px solid #eee;
        }


        /* Hover Effect */

        .book-library-table tbody tr:hover {
            background: #f5f9fc;
        }


        /* Edit Button */

        .book-edit-button {
            background: #2271b1 !important;
            color: white !important;
            border: none !important;
            padding: 6px 12px !important;
            border-radius: 5px !important;
        }


        .book-edit-button:hover {
            background: #135e96 !important;
        }


        /* Delete Button */

        .book-delete-button {
            background: #d63638 !important;
            color: white !important;
            border: none !important;
            padding: 6px 12px !important;
            border-radius: 5px !important;
        }


        .book-delete-button:hover {
            background: #b32d2e !important;
        }


        /* Page Background */

        .book-library-container {
            padding-right: 20px;
        }

    </style>


    <div class="wrap book-library-container">

        <h1>📚 Book Library Management</h1>


        <?php if ($edit_index >= 0 && isset($books[$edit_index])) : ?>

            <!-- Edit Book -->

            <h2>✏️ Edit Book</h2>

            <form method="post" class="book-library-form">

                <input
                    type="hidden"
                    name="edit_index"
                    value="<?php echo esc_attr($edit_index); ?>"
                >

                <table class="form-table">

                    <tr>
                        <th>Book Title</th>

                        <td>
                            <input
                                type="text"
                                name="edit_title"
                                value="<?php echo esc_attr($books[$edit_index]['title']); ?>"
                                required
                            >
                        </td>
                    </tr>


                    <tr>
                        <th>Author</th>

                        <td>
                            <input
                                type="text"
                                name="edit_author"
                                value="<?php echo esc_attr($books[$edit_index]['author']); ?>"
                                required
                            >
                        </td>
                    </tr>


                    <tr>
                        <th>Category</th>

                        <td>
                            <input
                                type="text"
                                name="edit_category"
                                value="<?php echo esc_attr($books[$edit_index]['category']); ?>"
                                required
                            >
                        </td>
                    </tr>


                    <tr>
                        <th>Publication Year</th>

                        <td>
                            <input
                                type="number"
                                name="edit_year"
                                value="<?php echo esc_attr($books[$edit_index]['year']); ?>"
                                required
                            >
                        </td>
                    </tr>

                </table>


                <p>

                    <input
                        type="submit"
                        name="update_book"
                        value="Update Book"
                    >

                    <a
                        href="<?php echo esc_url(admin_url('admin.php?page=book-library')); ?>"
                        class="button"
                    >
                        Cancel
                    </a>

                </p>

            </form>

        <?php endif; ?>


        <!-- Add Book -->

        <h2>➕ Add New Book</h2>

        <form method="post" class="book-library-form">

            <table class="form-table">

                <tr>
                    <th>Book Title</th>

                    <td>
                        <input
                            type="text"
                            name="book_title"
                            required
                        >
                    </td>
                </tr>


                <tr>
                    <th>Author</th>

                    <td>
                        <input
                            type="text"
                            name="book_author"
                            required
                        >
                    </td>
                </tr>


                <tr>
                    <th>Category</th>

                    <td>
                        <input
                            type="text"
                            name="book_category"
                            required
                        >
                    </td>
                </tr>


                <tr>
                    <th>Publication Year</th>

                    <td>
                        <input
                            type="number"
                            name="book_year"
                            required
                        >
                    </td>
                </tr>

            </table>


            <p>
                <input
                    type="submit"
                    name="add_book"
                    value="Add Book"
                >
            </p>

        </form>


        <!-- Books List -->

        <h2>📖 All Books</h2>


        <?php if (!empty($books)) : ?>

            <table class="book-library-table">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Publication Year</th>
                        <th>Actions</th>
                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($books as $index => $book) : ?>

                        <tr>

                            <td>
                                <?php echo esc_html($index + 1); ?>
                            </td>

                            <td>
                                <?php echo esc_html($book['title']); ?>
                            </td>

                            <td>
                                <?php echo esc_html($book['author']); ?>
                            </td>

                            <td>
                                <?php echo esc_html($book['category']); ?>
                            </td>

                            <td>
                                <?php echo esc_html($book['year']); ?>
                            </td>

                            <td>

                                <!-- Edit -->

                                <a
                                    href="<?php echo esc_url(
                                        admin_url(
                                            'admin.php?page=book-library&edit_book=' . $index
                                        )
                                    ); ?>"
                                    class="book-edit-button"
                                >
                                    Edit
                                </a>


                                <!-- Delete -->

                                <form
                                    method="post"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this book?');"
                                >

                                    <input
                                        type="hidden"
                                        name="delete_book"
                                        value="<?php echo esc_attr($index); ?>"
                                    >

                                    <input
                                        type="submit"
                                        value="Delete"
                                        class="book-delete-button"
                                    >

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        <?php else : ?>

            <p>No books have been added yet.</p>

        <?php endif; ?>

    </div>

    <?php
}