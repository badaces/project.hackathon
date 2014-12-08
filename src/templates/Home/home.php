<?php $this->layout('Base/default', ['title' => 'Home']) ?>

<header>
	<h1>Application Name</h1>

	<p>Application description Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit quis explicabo, at totam tempora cumque, qui quaerat praesentium, quod voluptatem tempore aliquam dicta nisi blanditiis debitis soluta, eveniet dolor cum eligendi quas. Expedita nam nulla molestiae corrupti sunt sit earum, numquam temporibus. Repellat rerum omnis repudiandae hic placeat, eligendi impedit, reiciendis quos recusandae eveniet quam deleniti cupiditate perspiciatis, iusto quisquam.</p>
</header>

<div class="greenhouse-toggle">Toggle Greenhouse Effect</div>
<h2 class="scene-title">Greenhouse Gas Concentrations</h2>
<p class="data-credit">Data provided by NOAA Mauna Loa Observatory</p>

<div id="main-canvas">
	<div id="stage-wrapper" class="scene-CO2pollution">

		<div class="infographic">
			<div class="stage-wrapper">
				<img class="stage stage-CO2-img" src="<?= $this->asset('/svg/stage_CO2pollution.svg') ?>" width="100%" height="auto" alt="">
			</div>
			<div class="scene-wrapper scene-CO2">
				<img class="scene scene-CO2-img" src="<?= $this->asset('/svg/scene_industrial_CO2.svg') ?>" width="100%" height="auto" alt="">
				<div class="greenhouse-effect">
					<img src="<?= $this->asset('/img/greenhouse_bubble.png') ?>" width="100%" height="auto" alt="">
				</div>
				<div class="data-holder cloud cloud-CO2-01">
					<div class="label">
						<span class="legend"><span class="label"></span></span>
						<span class="stats"></span>
						<span class="unit"></span>
					</div>
					<div class="info-popbox"></div>
					<img src="<?= $this->asset('/svg/cloud.svg') ?>" width="100%" height="auto" alt="">
				</div>
				<div class="data-holder cloud cloud-CO2-02">
					<div class="label">
						<span class="legend"><span class="label"></span></span>
						<span class="stats"></span>
						<span class="unit"></span>
					</div>
					<div class="info-popbox"></div>
					<img src="<?= $this->asset('/svg/cloud.svg') ?>" width="100%" height="auto" alt="">
				</div>
				<div class="data-holder cloud cloud-CO2-03">
					<div class="label">
						<span class="legend"><span class="label"></span></span>
						<span class="stats"></span>
						<span class="unit"></span>
					</div>
					<div class="info-popbox"></div>
					<img src="<?= $this->asset('/svg/cloud.svg') ?>" width="100%" height="auto" alt="">
				</div>
				<div class="data-holder cloud cloud-CO2-04">
					<div class="label">
						<span class="legend"><span class="label"></span></span>
						<span class="stats"></span>
						<span class="unit"></span>
					</div>
					<div class="info-popbox"></div>
					<img src="<?= $this->asset('/svg/cloud.svg') ?>" width="100%" height="auto" alt="">
				</div>
				<div class="data-holder cloud cloud-CO2-05">
					<div class="label">
						<span class="legend"><span class="label"></span></span>
						<span class="stats"></span>
						<span class="unit"></span>
					</div>
					<div class="info-popbox"></div>
					<img src="<?= $this->asset('/svg/cloud.svg') ?>" width="100%" height="auto" alt="">
				</div>
				<div class="data-holder cloud cloud-CO2-06">
					<div class="label">
						<span class="legend"></span>
						<span class="stats"></span>
						<span class="unit"></span>
					</div>
					<div class="info-popbox">
						<h3>Headline here</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam iste atque laborum ratione, culpa deserunt ut, commodi. Omnis illum deleniti quisquam nisi deserunt iure quidem, nulla quas necessitatibus, doloremque nihil!</p>
						<a href="" class="close-action"></a>
					</div>
					<img src="<?= $this->asset('/svg/cloud.svg') ?>" width="100%" height="auto" alt="">
				</div>
			</div>
		</div>

		<div class="associated-data"></div>
	</div>
</div>

<div id="information-wrapper">
	<div class="source-header">Wikipedia</div>
	<div class="info-injector">
		<h2>Greenhouse effect</h2>
		<p>Introduction and description of the subject lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi beatae magnam, blanditiis, quae sint aspernatur voluptatum veniam unde corporis vero harum. Inventore facere vel repellendus mollitia laboriosam quis expedita voluptate voluptatem repudiandae, hic quia porro, ab odio aspernatur.</p>
		<p>Tetur adipisicing elit. Odit sit, fuga saepe odio impedit aperiam magnam nulla voluptas sequi dolor et deserunt, deleniti tempora quas libero eligendi recusandae id praesentium! Nostrum at iusto dignissimos necessitatibus distinctio atque minus autem possimus enim, officia ratione beatae magnam ea. Vitae autem labore pariatur.</p>
		<p>Odit sit, fuga saepe odio impedit aperiam magnam nulla voluptas sequi dolor et deserunt, deleniti tempora quas libero eligendi recusandae id praesentium! Nostrum at iusto dignissimos necessitatibus distinctio atque minus autem possimus enim, officia ratione beatae magnam ea. Vitae autem labore pariatur.</p>
		<p class="source-caption"></p>
	</div>

	<div class="additional-data"></div>
	<div class="additional-data twitter-feed"></div>

</div>

<div id="main-canvas-selectors">
	<ul>
		<li class="select-cryosphere"><span class="icon"></span><span class="label">Cryosphere</span></li>
		<li class="select-hydrosphere"><span class="icon"></span><span class="label">Hydrosphere</span></li>
		<li class="select-lithosphere"><span class="icon"></span><span class="label">Lithosphere</span></li>
		<li class="select-atmosphere"><span class="icon"></span><span class="label">Atmosphere</span></li>
	</ul>
</div>