<?php
use \BeansWoo\Helper;

$beans_is_setup = Helper::isSetup();

?>

<style>
	<style>
	.beans-admin-container {
		text-align: center;
	}

	.beans-admin-container div {
		display: block;
		margin: auto;
	}

	.beans-admin-logo {
		height: 40px;
		width: auto;
		display: block;
		margin: 40px auto 20px;
	}

	.beans-admin-content {
		max-width: 600px;
		text-align: left;
		padding: 30px 60px;
		box-sizing: border-box;
	}


	p.beans-admin-check-warning a {
		color: #fffca6;
	}

	p.beans-admin-check-warning a:hover {
		color: #dce249;
	}


	.beans-apps-table img{
		height: 30px;
		width: auto;
	}
	.beans-apps-table td{
		padding: 20px 0;
	}
	.beans-apps-table p{
		margin: auto;
	}
    .btn {
        border-radius: 4px;
        padding: 10px 24px;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        border: None;
    }
    .bg-primary {
        background-color: #f9283e !important;
        color: white !important;
        opacity: 0.75;
        text-transform: uppercase;
    }
    .bg-primary:hover{
        cursor: pointer;
        opacity: 1;
    }
</style>

<div class="beans-admin-container">
	<img class="beans-admin-logo" src="https://trybeans.s3.amazonaws.com/static-v3/connect/img/beans.svg" alt="Beans">
	<div class="welcome-panel beans-admin-content">
		<div style="display: flex; justify-content: center">
            <div>
				<?php if( $beans_is_setup ): ?>
                    <a class="btn bg-primary" href='<?php echo admin_url( 'admin.php?page=beans-woo-settings&reset_beans=1' ); ?>'>Reset Settings Now</a>
				<?php else: ?>
					<a  href='javascript:void(0)'>Reset Settings Now</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

