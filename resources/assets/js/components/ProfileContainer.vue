<template>
	<div>
		<div class="md-layout md-gutter no-margin md-alignment-top-center">
			<QuickSearch 
				class="md-layout-item md-medium-size-95 md-size-33 md-small-hide vertical-spacing"
			></QuickSearch>
			<div class="md-layout-item">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
	import Navbar from './common/Navbar';
	import QuickSearch from './QuickSearch';

	export default {
		name: 'ProfileContainer',
		components: {
			Navbar, QuickSearch
		},
	};
</script>