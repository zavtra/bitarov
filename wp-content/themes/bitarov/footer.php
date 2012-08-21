
<!-- подвал -->
    <div class='clear'></div>
    <div class='footer'>
        <div class='wrap'>
            <div class='vendor'>
                <a href='http://zavtradigital.ru/'>Разработка сайта</a> &mdash; <span>digital-агентство &#171;Zavtra&#187;</span>
            </div>
			<?php 
			
			$args = array(  
			  'menu'            => 'footer',             
			  'container'       => 'div',  
			  'menu_class' => 'footer-menu',
			);  		

			wp_nav_menu($args); ?>
        </div>
    </div>
</div>

</body>
</html>