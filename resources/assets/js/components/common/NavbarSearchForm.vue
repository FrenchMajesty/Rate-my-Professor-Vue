<template>
	<div class="ml-auto mr-auto col-sm-8 col-md-7 col-lg-5">
		<b-nav-form@submit.prevent="submitSearch">
	        <md-field class="reduced-margin-bottom">
		      	<label>I'm looking for</label>
		    	<md-input 
		    		v-model="query"
		    		placeholder="Search here"
		    		autocomplete="off"
		    		@input="updateQueryValue"
		    		@keydown.enter="selectCurrentValue"
		    		@keydown.up="decreaseCurrentValueIndex"
		    		@keydown.down="increaseCurrentValueIndex"
		    		@keydown.esc="performingSearch=false"
		    		></md-input>
		   	</md-field>
	    </b-nav-form>
		<md-list v-if="showSuggestions" class="full-width" style="position: absolute">
			<md-list-item
				class="full-width"
				:class="{'active': i == currentValue}"
				:key="prof.id"
				v-for="(prof, i) in profMatches"
			>
			<md-button class="full-width" href="#">{{prof.firstname}} {{prof.lastname}}</md-button>
		</md-list-item>
		</md-list>
	</div>
</template>

<script>
	import { loadAllProfessorsData } from 'Js/store/api';
	export default {
		name: 'NavbarSearchForm',
		created() {
			const {data, beingFetched} = this.$store.state.prof;
			if(!data && !beingFetched) {
				this.fetchData();
			}
		},
		data() {
			return {
				query: '',
				performingSearch: false,
				currentValue: 0,
			};
		},
		computed: {
			schoolMatches() {
				return ['a'];
			},
			profData() {
				return this.$store.state.prof.data;
			},
			profMatches() {
				const {query, profData} = this;
				let results = [];

				if(profData && profData.length > 0) {
					profData.forEach((prof) => {
						const regex = new RegExp(query, 'gi');
						if(prof.firstname.match(regex) || prof.lastname.match(regex)) {
							results.push(prof);
						}

						results = results.slice(0,5);
					});
				}

				return results;
			},
			showSuggestions() {
				return this.query != '' && 
						this.schoolMatches.length > 0 &&
						this.profMatches.length > 0 &&
						this.performingSearch === true &&
						window.innerWidth > 775;
			},
		},
		methods: {
			fetchData() {
				this.$store.commit('updateProfsDataFetchingStatus', true);

				loadAllProfessorsData().then(res => {
					this.$store.commit({
						type: 'updateProfsData',
						data: res.data.profs,
					});
				})
				.catch(error => console.log(error));
			},
			submitSearch(e) {
				console.log(e);
			},
			updateQueryValue() {
				this.performingSearch = true;
				this.currentValue = 0;
			},
			selectCurrentValue() {
				if(this.profMatches.length > 0) {
					this.performingSearch = false;
					const prof = this.profMatches[this.currentValue];

					console.log(`Navigating to /prof/${prof.id}`, `${prof.firstname} ${prof.lastname}`);
				}
			},
			decreaseCurrentValueIndex() {
				if(this.currentValue > 0) {
					this.currentValue--;
				}
			},
			increaseCurrentValueIndex() {
				if(this.currentValue < this.profMatches.length-1) {
					this.currentValue++;
				}
			},
		},
	};
</script>

<style scoped>
	.reduced-margin-bottom {
		margin-bottom: 5px;
	}
	.full-width {
		width: 100%;
	}
	.above-all {
		z-index: 9999;
	}
	.active {
		background: #f7f7f7;
	}
</style>