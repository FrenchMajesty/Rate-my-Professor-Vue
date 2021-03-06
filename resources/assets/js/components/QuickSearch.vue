<template>
	<div class="md-layout md-alignment-center">
		<div class="md-layout-item md-medium-size-100 md-size-20 text-center">
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
		<div class="md-layout-item md-medium-size-80">
			<transition name="component-fade" mode="out-in">
				<md-card class="no-overflow" key="prof" v-if="currentMode == 'prof'" md-with-hover>
			        <md-card-header>
			          <div class="md-title">Find a professor</div>
			          <div class="md-subhead">You can search by name or by school.</div>
			        </md-card-header>

			        <md-card-content>
			        	<md-switch
			        		v-model="prof.searchBySchool"
			        	>Search by {{prof.searchBySchool ? 'school' : 'name'}}</md-switch>

			        	<form ref="prof" @submit.prevent="">
			        		<transition
					  			name="search"
					  			mode="out-in"
					  			enter-active-class="animated bounceIn"
					  			leave-active-class="animated bounceOut"
					  		>
				        		<md-autocomplete 
				        			v-if="searchIsReady" 
				        			v-model="prof.selected" 
				        			:md-options="profMatches"
				        			:md-open-on-focus="false"
				        			md-input-placeholder="Enter your professor's name"
				        			md-dense
				        		>
								    <label>I'm looking for a professor named</label>
								     <template slot="md-autocomplete-item" slot-scope="{ item, term }">
								        <md-highlight-text :md-term="term">{{item.firstname}} {{item.lastname}}</md-highlight-text>
								     </template>
							      	<template slot="md-autocomplete-empty" slot-scope="{ term }">
							        	No profs matching "{{term}}" were found. <a @click="alert('added')">Add a new</a> one!
							      	</template>
							    </md-autocomplete>
					        	<div v-else class="mr-auto ml-auto text-center">
					    			<md-progress-spinner 
					    				:md-diameter="30"
					    				:md-stroke="3"
					    				md-mode="indeterminate"
					    			></md-progress-spinner>
								</div>
							</transition>
			        	</form>
			        </md-card-content>

			        <md-card-actions>
			          <md-button
			          	@click="performProfessorSearch"
			          	:disabled="! isProfSearchComplete"
			          >Search</md-button>
			        </md-card-actions>
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
	import 'vue-material/dist/vue-material.min.css';

	export default {
		name: 'QuickSearch',
		props: {
			/**
			 * The default search mode on which to load up the module in
			 * @type {Object}
			 */
			defaultMode: {
				type: String,
				default: 'prof',
			},
		},
		/**
		 * Wait 1 sec before allowing the search inputs to show to avoid useless transitions
		 */
		mounted() {
			setTimeout(() => this.canShowSearchBars = true, 800);
		},

		data() {
			return {
				/**
				 * Current search mode on screen
				 * @type {String}
				 */
				currentMode: this.defaultMode,

				/**
				 * Whether search bars are allowed to be shown
				 * @type {Boolean}
				 */
				canShowSearchBars: false,

				/**
				 * The limit on how many suggestions can be shown at once
				 * @type {Number}
				 */
				searchSuggestionsLimit: 5,

				/**
				 * Whether there is an ongoing search being done 
				 * @type {Boolean}
				 */
				performingSearch: false,

				/**
				 * Prof's search mode data
				 * @type {Object}
				 */
				prof: {
					/**
					 * Whether to search by school or not. Will search by name if true.
					 * @type {Boolean}
					 */
					searchBySchool: false,

					/**
					 * The professor that was selected by the user
					 * @type {Object}
					 */
					selected: null,

					/**
					 * The school that was selected to filter down professors
					 * @type {Object}
					 */
					school: null,
				},

				/**
				 * School's search mode data
				 * @type {Object}
				 */
				school: {
					searchByLocation: false,
				},
			};
		},
		computed: {
			/**
			 * Determine whether the data is ready for a search to be performed
			 * @return {Boolean} 
			 */
			searchIsReady() {
				const {data, beingFetched: fetching} = this.$store.state.prof;
				const {canShowSearchBars} = this;
				const hasData = (canShowSearchBars && data.length > 0);
				const noDataInDatabase = (canShowSearchBars && data.length == 0 && ! fetching);

				return hasData || noDataInDatabase;
			},

			/**
			 * Compute all the professors's data from the store's state
			 * @return {Array} 
			 */
			profData() {
				return this.$store.state.prof.data;
			},

			/**
			 * Comput the professors matches based on the search query
			 * @return {Array} 
			 */
			profMatches() {
				const {prof: {profName}, profData, searchSuggestionsLimit} = this;
				let results = [];

				if(profData && profData.length > 0) {
					profData.forEach((prof) => {
						const {firstname, lastname} = prof;
						const regex = new RegExp(profName, 'gi');
						const fullname = `${firstname} ${lastname}`;

						if(firstname.match(regex) || lastname.match(regex) || fullname.match(regex)) {
							results.push(prof);
						}

						results = results.slice(0, searchSuggestionsLimit);
					});
				}

				return results;
			},

			/**
			 * Determine whether the form to search for a professor is completed and 
			 * can be sumitted
			 * @return {Boolean} 
			 */
			isProfSearchComplete() {
				return this.prof.selected && this.prof.school;
			}
		},
		methods: {
			/**
			 * Generate the class for the search types buttons
			 * @param  {String} key The name of the card button for which the class is for
			 * @return {String}     
			 */
			generateButtonClass(key) {
				if(key == this.currentMode) {
					return 'md-fab md-primary';
				}

				return 'md-fab md-plain';
			},

			/**
			 * Submit the form to search for a professor
			 * @param  {Event} e event
			 * @return {Void}   
			 */
			performProfessorSearch(e) {
				console.log('submitted a search!');
			},
		},
	};
</script>

<style scoped>
.no-overflow {
	overflow: visible;
}
.full-width {
	width: 100%
}
.offset-md-05 {
	margin-left: 1.15%;
}
.component-fade-enter-active, .component-fade-leave-active {
  transition: opacity .2s ease;
}
.component-fade-enter, .component-fade-leave-to {
  opacity: 0;
}
.autocomplete-list {
	position: absolute;
	z-index: 100;
}
.autocomplete-result:hover {
	background: #f7f7f7;
}
</style>