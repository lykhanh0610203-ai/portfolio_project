<?php
function in_sao_viet_search_shortcode()
{
    ob_start();
    ?>
    <style>
        .sv-search-container {
            text-align: center;
            padding: 35px 20px;
        }

        .sv-search-container h1 {
            font-size: 48px;
            font-weight: 800;
            color: var(--color-third);
            margin-bottom: 20px;
        }

        .sv-search-container .breadcrumb {
            font-size: 16px;
            color: #555;
            margin-bottom: 40px;
        }

        .sv-search-bar {
            display: flex;
            align-items: flex-start;

            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            padding: 20px 15px 0px;
        }

        .sv-search-bar input {
            flex: 1;
            font-size: 16px;
            padding-left: 52px;
            border: none;
            outline: none;
            background: url('data:image/svg+xml;utf8,<svg fill="black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M505 442.7L405.3 343c28.3-34.9 45.2-79.4 45.2-127C450.5 96.5 354 0 233.3 0S16 96.5 16 216.3 112.5 432.6 233.3 432.6c48.2 0 92.7-17 127.6-45.2l99.7 99.7c4.6 4.6 10.6 6.9 16.5 6.9s11.9-2.3 16.5-6.9c9.2-9.1 9.2-24 0-33.1zM64 216.3C64 127.8 127.8 64 233.3 64s169.3 63.8 169.3 152.3-63.8 152.3-169.3 152.3S64 304.8 64 216.3z"/></svg>') no-repeat 15px 13px;
            background-size: 20px;
            box-shadow: unset !important;
        }

        .sv-search-bar button {
            background: linear-gradient(135deg, #009cff, #7f3bff);
            color: white;
            font-weight: bold;
            padding: 12px 30px 13px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
            line-height: 1;
            margin-top: -3px;
        }


        .sv-search-bar button:hover {
            background: linear-gradient(135deg, #007bdc, #5f25c2);
        }

        .sv-search-container a {
            font-weight: 600;
        }


        .sv-search-container a:hover {
            color: #000;
            cursor: pointer;

        }

        @media (max-width: 600px) {
            .sv-search-bar {
                flex-direction: column;
            }

            .sv-search-bar button {
                width: 100%;
                padding: 15px;
            }
        }
    </style>

    <div class="sv-search-container">
        <h1><?php echo get_the_title(); ?></h1>

        <?php echo do_shortcode('[dynamic_breadcrumb]'); ?>
    </div>

    <form class="sv-search-bar" method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" name="s" placeholder="Giao diện, lĩnh vực muốn tìm...">
        <button type="submit">Tìm kiếm</button>
    </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('in_sao_viet_search', 'in_sao_viet_search_shortcode');
