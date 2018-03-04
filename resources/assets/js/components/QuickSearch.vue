<template>
	<div class="row">
		<div class="col-md-12 col-lg-2 offset-sm-0 offset-md-05">
			<md-button v-show="false" class="md-fab"></md-button>
			<!-- That button is there so that the 3 below are aligned correctly -->
			<md-button :class="generateButtonClass('prof')" @click="currentMode = 'prof'">
		        <md-icon>person</md-icon>
		     </md-button>
		     <md-button :class="generateButtonClass('school')" @click="currentMode = 'school'">
		        <md-icon>school</md-icon>
		     </md-button>
		     <md-button :class="generateButtonClass('review')" @click="currentMode = 'review'">
		        <md-icon>star</md-icon>
		     </md-button>

		</div>
		<div class="col-md-12 col-lg-8">
			<transition name="component-fade" mode="out-in">
				<md-card key="prof" v-if="currentMode == 'prof'" md-with-hover>
			      <md-ripple>
			        <md-card-header>
			          <div class="md-title">Find a professor</div>
			          <div class="md-subhead">You can search by name or by school.</div>
			        </md-card-header>

			        <md-card-content>
			          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non..
			        </md-card-content>

			        <md-card-actions>
			          <md-button>Search</md-button>
			        </md-card-actions>
			      </md-ripple>
			    </md-card>
			    <md-card key="school" v-if="currentMode == 'school'" md-with-hover>
			      <md-ripple>
			        <md-card-header>
			          <div class="md-title">Find a School</div>
			          <div class="md-subhead">You can search by name or by state.</div>
			        </md-card-header>

			        <md-card-content>
			          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non..
			        </md-card-content>

			        <md-card-actions>
			          <md-button>Search</md-button>
			        </md-card-actions>
			      </md-ripple>
			    </md-card>
			</transition>
		</div>
	</div>
</template>

<script>
	import Button from './common/form/Button';
	import 'vue-material/dist/vue-material.min.css';

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
			defaultMode: {
				type: String,
				default: 'prof',
			},
		},
		data() {
			return {
				currentMode: this.defaultMode,
			};
		},
		methods: {
			generateButtonClass(key) {
				if(key == this.currentMode) {
					return 'md-fab md-primary';
				}

				return 'md-fab md-plain';
			},
		},
	};
</script>

<style scoped>
.offset-md-05 {
	margin-left: 4.15%;
}
.component-fade-enter-active, .component-fade-leave-active {
  transition: opacity .2s ease;
}
.component-fade-enter, .component-fade-leave-to {
  opacity: 0;
}
</style>