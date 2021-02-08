<?php

include('./include/header-banner.php');

session_start();

if ($_SESSION['user_blocked'] == 1) {
	header('location: /account/logout/?url=banned');
}

if (!isset($_SESSION['user_id'])) {
	header('location: /account/logout/');
	exit();
}

if ($_SESSION['user_2fa'] == "1" && empty($_SESSION['control_2FA'])) {
	header('location: /account/two-factor-authentication/');
}

?>
<meta http-equiv="refresh" content="1440;url=/account/logout/?url=timeout" />
<div class="container mt-5 mb-5">
	<?php echo $_SESSION['success'];
	unset($_SESSION['success']); ?>
	<div class="row gutters-sm">
		<div class="col-md-4 d-none d-md-block">
			<div class="card">
				<div class="card-body">
					<nav class="nav flex-column nav-pills nav-gap-y-1">
						<a href="#profile" data-toggle="tab" data-target="#profile" class="nav-item nav-link has-icon nav-link-faded active">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
								<circle cx="12" cy="7" r="4"></circle>
							</svg>Profile Information
						</a>
						<a href="#account" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2">
								<circle cx="12" cy="12" r="3"></circle>
								<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
							</svg>Account Settings
						</a>
						<a href="#socials" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2">
								<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
							</svg> Your Socials
						</a>
						<a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2">
								<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
							</svg>Security
						</a>
						<!-- <a href="#notification" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell mr-2">
								<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
								<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
							</svg>Notification
						</a> -->
						<a href="#billing" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2">
								<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
								<line x1="1" y1="10" x2="23" y2="10"></line>
							</svg>Billing
						</a>
						<a href="#purchased" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart mr-2">
								<circle cx="9" cy="21" r="1"></circle>
								<circle cx="20" cy="21" r="1"></circle>
								<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
							</svg>
							Purchased items
						</a>
						<a href="#uploads" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload-cloud mr-2">
								<polyline points="16 16 12 12 8 16"></polyline>
								<line x1="12" y1="12" x2="12" y2="21"></line>
								<path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
								<polyline points="16 16 12 12 8 16"></polyline>
							</svg>My Uploads
						</a>
					</nav>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card">
				<div class="card-header border-bottom mb-3 d-flex d-md-none">
					<ul class="nav nav-tabs card-header-tabs nav-gap-x-1" id="myTab" role="tablist">
						<li class="nav-item">
							<a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
									<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
									<circle cx="12" cy="7" r="4"></circle>
								</svg></a>
						</li>
						<li class="nav-item">
							<a href="#account" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
									<circle cx="12" cy="12" r="3"></circle>
									<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
								</svg></a>
						</li>
						<li class="nav-item">
							<a href="#socials" data-toggle="tab" class="nav-link has-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
									<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
								</svg>
							</a>
						</li>
						<li class="nav-item">
							<a href="#security" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
									<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
								</svg></a>
						</li>
						<!-- <li class="nav-item">
							<a href="#notification" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
									<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
									<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
								</svg></a>
						</li> -->
						<li class="nav-item">
							<a href="#billing" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
									<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
									<line x1="1" y1="10" x2="23" y2="10"></line>
								</svg></a>
						</li>
						<a href="#purchased" data-toggle="tab" class="nav-link has-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart mr-2">
								<circle cx="9" cy="21" r="1"></circle>
								<circle cx="20" cy="21" r="1"></circle>
								<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
							</svg>
						</a>
						<li class="nav-item">
							<a href="#uploads" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload-cloud mr-2">
									<polyline points="16 16 12 12 8 16"></polyline>
									<line x1="12" y1="12" x2="12" y2="21"></line>
									<path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
									<polyline points="16 16 12 12 8 16"></polyline>
								</svg></a>
						</li>
					</ul>
				</div>
				<div class="card-body tab-content">
					<div class="tab-pane active" id="profile">
						<h6>PROFILE INFORMATION</h6>
						<hr>
						<form action="/pages/account/helper/profile.edit.php" method="post">
							<div class="form-group">
								<label for="email">Email <a href="#info" class="text text-danger">*</a> </label>
								<input type="text" class="form-control" name="email" id="email" maxlength="32" aria-describedby="emailHelp" placeholder="Enter your email" value="<?php echo $_SESSION['user_email']; ?>" required>
								<small id="emailHelp" class="form-text text-muted">Your email which is used to send you the newest updates and account updates, if you enabled it in the notifications tab.</small>
							</div>
							<div class="form-group">
								<label for="bio">Description</label>
								<textarea class="form-control autosize" name="desc" id="textarea" maxlength="100" placeholder="Write something about you" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"><?php echo $_SESSION['user_description']; ?></textarea>
								<small id="emailHelp" class="form-text text-muted">Maximal characters: 100</small>
							</div>
							<div class="form-group">
								<label for="url">Website</label>
								<input type="text" class="form-control" name="website" id="noSpace" maxlength="64" pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$" name="website" placeholder="Enter your website address" value="<?php echo $_SESSION['user_website']; ?>">
							</div>
							<div class="form-group">
								<label for="location">Location</label>
								<input type="text" class="form-control" name="location" id="location" minlength="2" maxlength="48" placeholder="Enter your location" value="<?php echo $_SESSION['user_locale']; ?>">
							</div>
							<div class="form-group small text-muted" id="info">
								Fields marked with <span class="text text-danger">*</span> are mandatory fields and must be filled out.
							</div>
							<input type="text" name="call" value="callFunc" hidden>
							<input type="text" name="id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
							<button type="submit" class="btn btn-primary">Save & Update</button>
							<button type="reset" class="btn btn-light">Reset Changes</button>
						</form>
						<!-- <p class="mt-4 form-group small text-muted">Mit <span class="text text-danger">*</span> gekennzeichnete Felder sind sogennante Pflichtfelder und müssen ausgefüllt werden.</p> -->
					</div>
					<div class="tab-pane fade" id="account">
						<h6>ACCOUNT SETTINGS</h6>
						<hr>
						<form action="/pages/account/helper/account.edit.php" method="post">
							<div class="form-group">
								<label for="username">Username <a href="#info" class="text text-danger">*</a></label>
								<input type="text" class="form-control" id="noSpace2" pattern="[a-zA-Z0-9]+(?:[_-]?[a-zA-Z0-9])" name="username" aria-describedby="usernameHelp" value="<?php echo $_SESSION['user_username']; ?>" placeholder="Enter your username" required>
								<small id="usernameHelp" class="form-text text-muted">After changing your username, your old username becomes available for anyone else to claim.</small>
							</div>
							<div class="form-group">
								<label for="username">Global banner</label>
								<input type="text" class="form-control" name="gbanner" pattern="(http(s?):)([/|.|\w|\s|-])*\.(?:jpg|gif|png|jpeg|webp)" aria-describedby="gbanner" value="<?php echo $_SESSION['user_banner']; ?>" placeholder="Enter a valid image url to your prefered banner. Resolution: 1900x70">
								<small id="usernameHelp" class="form-text text-muted">You can change the global banner in the header to your prefered design. Just enter a valid image url.</small>
								<input type="text" name="call" value="callFunc" hidden>
								<input type="text" name="id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
								<div class="form-group small text-muted mt-3" id="info">
									Fields marked with <span class="text text-danger">*</span> are mandatory fields and must be filled out.
								</div>
								<button type="submit" class="btn btn-primary">Save & Update</button>
							</div>
						</form>
						<?php

						if ($_SESSION['user_premium'] == "1") {
							echo '<hr>
							<form>
								<div class="form-group mb-0">
									<label class="d-block">Premium Partner</label>
									<p class="font-size-sm text-muted">You are part of our partner program. Make sure to have two factor authentication. always enabled! Partner benefits & conditions apply.</p>
								</div>
							</form>';
						}

						?>
						<hr>
						<form>
							<div class="form-group mb-0">
								<label class="d-block">Login type</label>
								<p class="font-size-sm text-muted">You are using <b><?php echo $_SESSION['user_oauth_provider']; ?></b> as login provider. To change your provider please create a ticket in our <a href="/ref?rdc=https://discord.com/invite/AGvh9HX">discord</a> or send us a <a href="mailto://contact@fivemods.net?subject=FiveMods.net%20Login%20provider%20change">mail</a>.</p>
							</div>
						</form>
						<form action="" method="post">
							<hr>
							<div class="form-group">
								<label class="d-block text-danger">Delete Account</label>
								<p class="text-muted font-size-sm">Once you delete your account, there is no going back. Please be certain.</p>
							</div>
							<a href="/account/delete/" class="btn btn-danger" type="button">Delete Account</a>
						</form>
					</div>
					<div class="tab-pane fade" id="socials">
						<h6>YOUR SOCIALS</h6>
						<hr>
						<form action="/pages/account/helper/socials.edit.php" method="post">
							<div class="form-group">
								<label for="discord">Discord server</label>
								<div class="input-group mb-2 mr-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://discord.gg/invite/</div>
									</div>
									<input type="text" class="form-control" name="discord" id="discord" placeholder="Your discord server" value="<?php echo $_SESSION['user_discord']; ?>">
								</div>
								<small id="fullNameHelp" class="form-text text-muted">Your discord server may appear around here where you are mentioned. You can change or remove it at any time.</small>
							</div>
							<div class="form-group">
								<label for="twitter">Twitter</label>
								<div class="input-group mb-2 mr-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://twitter.com/</div>
									</div>
									<input type="text" class="form-control" name="twitter" id="twitter" placeholder="Your twitter account" value="<?php echo $_SESSION['user_twitter']; ?>">
								</div>
								<small id="fullNameHelp" class="form-text text-muted">Your twitter account may appear around here where you are mentioned. You can change or remove it at any time.</small>
							</div>
							<div class="form-group">
								<label for="youtube">YouTube</label>
								<div class="input-group mb-2 mr-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://youtube.com/</div>
									</div>
									<input type="text" class="form-control" name="youtube" id="youtube" placeholder="Your youtube channel" value="<?php echo $_SESSION['user_youtube']; ?>">
								</div>
								<small id="fullNameHelp" class="form-text text-muted">Your youtube channel may appear around here where you are mentioned. You can change or remove it at any time.</small>
							</div>
							<div class="form-group">
								<label for="instagram">Instagram</label>
								<div class="input-group mb-2 mr-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://instagram.com/</div>
									</div>
									<input type="text" class="form-control" name="instagram" id="instagram" placeholder="Your instagram account" value="<?php echo $_SESSION['user_instagram']; ?>">
								</div>
								<small id="fullNameHelp" class="form-text text-muted">Your instagram account may appear around here where you are mentioned. You can change or remove it at any time.</small>
							</div>
							<div class="form-group">
								<label for="github">GitHub</label>
								<div class="input-group mb-2 mr-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://github.com/</div>
									</div>
									<input type="text" class="form-control" name="github" id="github" placeholder="Your github account" value="<?php echo $_SESSION['user_github']; ?>">
								</div>
								<small id="fullNameHelp" class="form-text text-muted">Your github account may appear around here where you are mentioned. You can change or remove it at any time.</small>
							</div>
							<input type="text" name="call" value="callFunc" hidden>
							<input type="text" name="id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
							<button type="submit" class="btn btn-primary">Save & Update</button>
							<button type="reset" class="btn btn-light">Reset Changes</button>
						</form>
						<!-- <p class="mt-4 form-group small text-muted">Mit <span class="text text-danger">*</span> gekennzeichnete Felder sind sogennante Pflichtfelder und müssen ausgefüllt werden.</p> -->
					</div>
					<div class="tab-pane fade" id="security">
						<h6>SECURITY SETTINGS</h6>
						<hr>
						<?php

						if (empty($_SESSION['user_2fa']) || $_SESSION['user_2fa'] == "0") {
							echo '<form>
							<div class="form-group">
								<label class="d-block">Two Factor Authentication</label>
								<a href="/account/two-factor-authentication/" class="btn btn-info">Enable Two-Factor Authentication</a>
								<p class="small text-muted mt-2">Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.</p>
							</div>
						</form>';
						} else {
							echo '<form action="/pages/account/helper/2fa.disable.php" method="post">
							<div class="form-group">
							<label class="d-block">Two Factor Authentication</label>
							<p class="small text-muted mt-2">Two-factor authentication is currenly enabled. this allows you to participate in our partner program and secures your account.</p>
							<input type="text" name="call" value="callFunc" hidden>
							<button type="submit" class="btn btn-danger">Disable Two Factor Authentication</button>
							<p class="small text-muted mt-2">Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.</p>
						</div>
						</form>';
						}

						?>

						<hr>
						<form action="" method="post">
							<div class="form-group mb-0">
								<label class="d-block">Sessions</label>
								<p class="font-size-sm text-secondary">This is a list of devices that have logged into your account. Revoke any sessions that you do not recognize.</p>
								<ul class="list-group list-group-sm">
									<li class="list-group-item has-icon">
										<div>
											<h6 class="mb-0"><?php echo $city; ?> | <?php echo $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']); ?></h6>
											<small class="text-muted">Your current session seen in <?php echo $countryName; ?>.</small>
										</div>
										<!-- <button class="btn btn-light btn-sm ml-auto" type="button">More info</button> -->
									</li>
								</ul>
							</div>
						</form>
					</div>
					<!-- @Oetkher -->
					<div class="tab-pane fade" id="billing">
						<h6>BILLING SETTINGS</h6>
						<hr>
						<?php
						$ch = curl_init();
						require_once "./config.php";

                  		$token = $apiToken;
						$userid = $_SESSION['user_id'];

						curl_setopt($ch, CURLOPT_URL, "http://85.214.166.192:8081");
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, "action=reqBalance&token=$token&uid=$userid");
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
						curl_close($ch);
						?>
						<div class="form-group">
							<label class="d-block mb-0" style="font-size:29px;"><b><?php echo $response; ?>€</b></label>
							<div class="small text-muted mb-3">Your current balance. Terms of Use apply.</div>
						</div>
						<label class="d-block mb-0">Payments</label>
						<a href="/payment/deposit" class="btn btn-success" type="button"><i class="fas fa-plus"></i>  Deposit money</a>
                        <hr>
						<label class="d-block mb-0">Payout</label>
						<small class="text-danger">IMPORTANT: Minimum payout amount: 10.00€</small>
						<br>
						<?php
						if (floatval($response) > 10.00)
							echo '<a href="/payment/payout" class="btn btn-info" type="button"><i class="fab fa-paypal"></i>  Request payout</a>';
						else
							echo '<button class="btn btn-info" disabled><i class="fab fa-paypal"></i>  Request payout</button>';
						?>
						<hr>
						<div class="form-group mb-0">
							<label class="d-block">Income History</label>
							<div class="border border-gray-500 bg-gray-200 p-3 text-center font-size-sm">

								<div class="container">

									<?php
									$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

									$result = $pdo->prepare("SELECT * FROM user LEFT JOIN mods ON user.id = mods.m_authorid WHERE mods.m_authorid = ?");
									$result->execute(array($_SESSION['user_iid']));

									if ($result->rowCount() > 0) {

										echo '<table class="table">
												<thead>
													<tr>
														<th scope="col">Mod-ID</th>
														<th scope="col">Estimated Income</th>
													</tr>
												</thead>
												<tbody>';

										// output data of each row
										while ($row = $result->fetch()) {

											echo '<tr>
														<th scope="row">' . $row['m_id'] . '</th>
														<td>' . ($row['m_downloads'] / 1000) . '€ </td>
													</tr>';
										}
									} else {
										echo 'There is no current income.';
									}

									?>

									</tbody>
									</table>
								</div>

							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="uploads">
						<h6>MY UPLOADS</h6>
						<hr>
						<div class="container">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">ID</th>
										<th scope="col">Name</th>
										<th scope="col">Status</th>
										<th scope="col">
											<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
												<polyline points="8 17 12 21 16 17"></polyline>
												<line x1="12" y1="12" x2="12" y2="21"></line>
												<path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
											</svg> </th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php

									$result = $pdo->prepare("SELECT * FROM user LEFT JOIN mods ON user.id = mods.m_authorid WHERE mods.m_authorid = ?");
									$result->execute(array($_SESSION['user_iid']));

									if ($result->rowCount() > 0) {
										while ($row = $result->fetch()) {

											if ($row['m_approved'] == 0 && $row['m_blocked'] == 0) {
												$status = '
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
												$edit = '<form action="/account/edit/" method="post"> <input type="number" name="id" value="' . $row['m_id'] . '" hidden> <input type="number" name="uid" value="' . $_SESSION['user_id'] . '" hidden> <button type="submit" class="btn bg-transparent btn-sm text-info">
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
												</form>';
											} elseif ($row['m_approved'] == 1 && $row['m_blocked'] == 0) {
												$status = '
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text text-warning"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>';
												$edit = '<form action="/account/edit/" method="post"> <input type="number" name="id" value="' . $row['m_id'] . '" hidden> <input type="number" name="uid" value="' . $_SESSION['user_id'] . '" hidden> <button type="submit" class="btn bg-transparent btn-sm text-info">
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
												</form>';
											} elseif ($row['m_blocked'] == 1) {
												$status = '
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash text text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>';
												$edit = '<button type="submit" class="btn bg-transparent btn-sm text-muted" disabled>
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>';
											} else {
												$status = '
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
												$edit = '<form action="/account/edit/" method="post"> <input type="number" name="id" value="' . $row['m_id'] . '" hidden> <input type="number" name="uid" value="' . $_SESSION['user_id'] . '" hidden> <button type="submit" class="btn bg-transparent btn-sm text-info">
												<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
												</form>';
											}

											echo '<tr>
													<th scope="row">' . $row['m_id'] . '</th>
													<td><a href="/product/' . $row['m_id'] . '/" class="text text-info">' . $row['m_name'] . '</a></td>
													<td>' . $status . '</td>
													<td>' . $row['m_downloads'] . '</td>
													<td>' . $edit . '</td>
												</tr>';
										}
									} else {
										echo '<tr>
													<th scope="row">#</th>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
												</tr>';
									}

									?>

								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="purchased">
						<h6>MY PURCHASES</h6>
						<hr>
						<div class="container">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">ID</th>
										<th scope="col">Product ID</th>
										<th scope="col">Status</th>
										<th scope="col">Price</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php

									

									$status = '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';

									$result = $pdo->prepare("SELECT * FROM product_log WHERE u_uuid = ?");
									$result->execute(array($_SESSION['user_uuid']));

									if ($result->rowCount() > 0) {
										// output data of each row
										while ($row = $result->fetch()) {

											echo '<tr>
													<th scope="row">' . $row['id'] . '</th>
													<td><a href="/product/' . $row['p_id'] . '/" class="text text-info">' . $row['p_id'] . '</a></td>
													<td>' . $status . '</td>
													<td>' . $row['price'] . '€</td>
													<td>
														<form action="/helper/manage.php?o=index&purchase='. $row['p_id'] . '" method="post">													
														<button type="submit" class="btn btn-sm btn-outline-info"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>
														</svg></button></form>
													</td>
												</tr>';
										}
									} else {
										echo '<tr>
													<th scope="row">#</th>
													<td>-</td>
													<td>-</td>
													<td>-</td>
													<td>-</td>
												</tr>';
									}

									?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script>
	var input = document.getElementById("noSpace");

	input.oninput = function(e) {
		e.target.value = e.target.value.replace(' ', '_');
		e.target.value = e.target.value.replace('™', 'TM');
		e.target.value = e.target.value.replace('®', 'R');
	}
</script>
<script>
	var input = document.getElementById("noSpace2");

	input.oninput = function(e) {
		e.target.value = e.target.value.replace(' ', '_');
		e.target.value = e.target.value.replace('™', 'TM');
		e.target.value = e.target.value.replace('®', 'R');
	}
</script>
<script>
	var input = document.getElementById("noSpace3");

	input.oninput = function(e) {
		e.target.value = e.target.value.replace(' ', '_');
		e.target.value = e.target.value.replace('™', 'TM');
		e.target.value = e.target.value.replace('®', 'R');
	}
</script>
<script>
	$(document).ready(function() {
		$("#success-alert").hide();
		$("#myWish").click(function showAlert() {
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
				$("#success-alert").slideUp(500);
			});
		});
	});
</script>

<?php
	$pdo = null;
?>