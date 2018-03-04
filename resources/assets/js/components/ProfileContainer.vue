<template>
	<div>
		<Navbar :user="user" :searchData="searchData"></Navbar>
		<div class="md-layout space-above">
			<div class="md-layout-item md-size-33">
				<QuickSearch :searchData="searchData" />
			</div>
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
		padding-top: 5em;
	}
</style>