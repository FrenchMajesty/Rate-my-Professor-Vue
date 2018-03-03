<template>
	<div class="row">
		<div class="col-md-12 col-lg-2 offset-sm-0 offset-md-05">
			<md-button v-show="false" class="md-fab"></md-button>

			<md-button class="md-fab">
		        <md-icon>person</md-icon>
		     </md-button>
		     <md-button class="md-fab">
		        <md-icon>school</md-icon>
		     </md-button>
		     <md-button class="md-fab">
		        <md-icon>star</md-icon>
		     </md-button>
		</div>
		<div class="col-md-12 col-lg-8">
			<md-card md-with-hover>
		      <md-ripple>
		        <md-card-header>
		          <div class="md-title">Card with hover effect</div>
		          <div class="md-subhead">It also have a ripple</div>
		        </md-card-header>

		        <md-card-content>
		          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non.
		        </md-card-content>

		        <md-card-actions>
		          <md-button>Action</md-button>
		          <md-button>Action</md-button>
		        </md-card-actions>
		      </md-ripple>
		    </md-card>
		</div>
	</div>
</template>

<script>
	import Button from './common/form/Button';

	export default {
		name: 'QuickSearch',
		components: {
			Button,
		},
		props: {
			searchData: {
				type: Array,
				required: true,
			},
		},
	};
</script>

<style scoped>
.offset-md-05 {
	margin-left: 4.15%;
}
</style>