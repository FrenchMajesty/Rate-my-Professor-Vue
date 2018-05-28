<template>
	<md-card class="md-layout md-gutter no-margin padding-above text-align-sm">
		<!-- Ratings container -->
      	<md-content 
      		class="md-layout-item md-xsmall-size-100 md-small-size-26 vertical-spacing md-layout text-center md-alignment-center"
      		v-if="ratings"
      	>
	      	<table class="md-layout-item md-medium-size-100 md-size-80">
	      		<tr 
	      			class="md-layout md-alignment-center row-margin"
	      			v-for="average in averages"
	      		>
	      			<td :class="`${scoreNumberClass} ${scoreRankingScale(average.value)}`">{{average.value}}</td>
	      			<td :class="scoreTextClass">{{average.label}}</td>
	      		</tr>
	      	</table>
     	</md-content>
     	<div 
     		v-else 
     		class="md-layout-item md-xsmall-size-100 md-small-size-26 vertical-spacing md-layout text-center"
     	></div>


      <!-- school info container -->
      <md-content class="md-layout-item md-xsmall-size-100 vertical-spacing">
      	<h1>{{school.name}} ({{school.nickname}})</h1>
      	<p class="md-subtitle">Located at {{school.location}}.</p>
      	<p>
      		<md-button class="md-fab md-mini md-raised" :href="school.website" target="_blank">
		    	<md-icon>public</md-icon>
      			<md-tooltip md-direction="right">Visit the website</md-tooltip>
		    </md-button>
      	</p>
      	<p><a href="#">Submit a correction</a></p>
      </md-content>

      <!-- profs info container -->
      <md-content class="md-layout-item md-xsmall-size-100 vertical-spacing">
      	<h1>Top Professors</h1>
      	<md-list class="md-double-list">
      		<md-list-item>
		        <div class="md-list-item-text" >
		        	<a :to="{name: 'professor', params:{ slug: 'dr-jonnie-beans'}}">Dr. Jonnie Beans</a>
		        	<span>35 Reviews</span>
		        </div>

		        <span class="md-list-action">5.0</span>
		    </md-list-item>
      	</md-list>
      </md-content>
    </md-card>
</template>

<script>
	export default {
		name: 'SchoolDetailsCard',
		props: {
			/**
			 * The school model
			 * @type {Object}
			 */
			school: {
				type: Object,
				required: true,
			},
			ratings: {
				type: Array,
				default: [],
			}
		},
		data() {
			return {
				scoreNumberClass: 'score md-layout-item md-medium-size-20 md-size-20',
				scoreTextClass: 'score-text md-layout-item',
			};
		},
		computed: {
			/**
			 * Calculate the number of professors in the same department
			 * @return {Number} 
			 */
			profsInDepartment() {
				return 2;
			},

			/**
			 * Calculate the number of professors at the same school
			 * @return {Number} 
			 */
			profsInSchool() {
				return 7;
			},

			averages() {
				if(this.ratings.length == 0) return null;

				const averages = [
					{label: 'Overall', value: this.average('overall')},
					{label: 'Location', value: this.average('location')},
					{label: 'Facilities', value: this.average('facilities')},
					{label: 'Opportunity', value: this.average('opportunity')},
					{label: 'Social', value: this.average('social')},
				];

				return averages;
			},
		},
		methods: {
			/**
			 * Calculate the average of a given rating
			 * @param  {String} ratingName The rating to calculate
			 * @return {Number}        
			 */
			average(ratingName) {
				const total = this.ratings.reduce((accu, rating) => Number(eval(`rating.${ratingName}_rating`)) + accu, 0);
				return Number(total / this.ratings.length).toFixed(1);
			},


			/**
			 * Determine the text color of the average rating
			 * @param {Number} score The score to evaluate
			 * @return {String} 
			 */
			scoreRankingScale(score) {
				if(score >= 3.8) {
					return 'text-success';
				}else if(score > 2.8) {
					return 'text-warning';
				}
				
				return 'text-danger';
			},
		}
	};
</script>

<style scoped>
	.row-margin {
		margin-bottom: 1.8em;
	}
	.padding-above {
		padding: 2em 0;
	}
	.score-text {
		font-size: 1.5em;
	}
	.score {
		font-size: 2.7em;
	}
	.smiley-container {
		margin-bottom: 2em;
	}
	.divider {
		margin: 2em 0;
	}
	.caption {
		opacity: 0.65;
		font-style: italic;
	}
	.text-align-sm {
		text-align: center;
	}
	@media (min-width: 600px) {
		.text-align-sm {
			text-align: inherit;
		}
	}
</style>