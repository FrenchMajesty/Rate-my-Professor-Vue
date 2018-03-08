<template>
	<div>
		<Navbar :user="user" :searchData="searchData"></Navbar>
		<div class="md-layout md-gutter no-margin md-alignment-top-center space-above">
			<QuickSearch 
				:searchData="searchData" 
				class="md-layout-item md-medium-size-95 md-size-33 md-small-hide vertical-spacing"
			/>
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
		props: {
			user: {
				type: Object,
			},
			searchData: {
				type: Array,
				required: true,
			}
		},
	};
</script>

<style scoped>
	.space-above {
		padding-top: 6.5em;
	}
</style>