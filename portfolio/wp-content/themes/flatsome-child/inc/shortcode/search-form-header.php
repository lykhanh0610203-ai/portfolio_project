<?php
function custom_search_bar_shortcode()
{
    ob_start();
    ?>
    <form class="search-bar-container" action="<?php echo home_url('/search'); ?>" method="get">
        <input type="text" class="search-input" placeholder="" value="" name="s">
        <button type="submit" class="search-button"><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg></span> Tìm giao diện</button>
    </form>
    <script>
        const texts = ["Bạn muốn tìm giao diện gì?", "Thời trang - Trang sức", "Nội thất - Trang trí"];
        let textIndex = 0;
        let charIndex = 0;
        const input = document.querySelector('.search-input');
        const intervalTime = 2000; // Change text every 2 seconds
        const typeSpeed = 100; // Typewriter effect speed in ms per character

        function typeWriter() {
            if (charIndex < texts[textIndex].length) {
                input.placeholder = texts[textIndex].substring(0, charIndex + 1);
                charIndex++;
                setTimeout(typeWriter, typeSpeed);
            } else {
                setTimeout(() => {
                    charIndex = 0;
                    textIndex = (textIndex + 1) % texts.length;
                    input.placeholder = '';
                    setTimeout(typeWriter, typeSpeed);
                }, intervalTime);
            }
        }

        // Start the typewriter effect
        typeWriter();
    </script>
    <style>
        .search-bar-container {
            display: flex;
            align-items: center;
            margin: 10px 0;
            background-color: #3ea5ab;
            border-radius: 20px;
            overflow: hidden;
        }

        .search-bar-container path {
            fill: #fff;
        }

        .search-bar-container svg {
            width: 15px;
            height: 15px;
        }

        .search-input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: none;
            background-color: #008CBA;
            color: #333;
            outline: none;
            cursor: text;
        }

        .search-button {
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 0 20px 20px 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-button {
            font-size: 12px;
            /* nhỏ hơn */
            padding: 6px 10px;
        }

        .search-button svg {
            width: 12px;
            height: 12px;
        }


        .search-bar-container input[type=text] {
            background-color: transparent;
            border: unset;
            border-radius: 0;
            box-shadow: unset;
            box-sizing: border-box;
            color: #333;
            font-size: .97em;
            height: 2.507em;
            max-width: 100%;
            padding: 0 .75em;
            transition: color .3s, border .3s, background .3s, opacity .3s;
            vertical-align: middle;
            width: 215px;
        }

        .search-bar-container input[type=text]::placeholder {
            color: #fff;
        }

        .search-input:focus {
            color: #333;
            background-color: #007B9A;
            outline: none;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_search_bar', 'custom_search_bar_shortcode');