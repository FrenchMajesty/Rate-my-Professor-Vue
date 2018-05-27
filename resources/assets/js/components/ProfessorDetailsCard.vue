<template>
	<md-card class="md-layout md-gutter no-margin padding-above text-align-sm">
		<!-- Ratings container -->
      	<md-content 
      		class="md-layout-item md-xsmall-size-100 md-small-size-26 vertical-spacing md-layout text-center"
      		v-if="ratings"
      	>
	      	<md-content class="md-layout-item md-size-100 smiley-container">
	      		<md-icon v-if="avgOverall" :class="'md-size-4x '+overallRankingScale">tag_faces</md-icon>
	      		<md-icon v-else class="md-size-4x">weekend</md-icon>
	      	</md-content>
	      	<table class="md-layout-item md-medium-size-100 md-size-80">
	      		<tr class="md-layout md-alignment-center">
	      			<td :class="`${scoreNumberClass} ${overallRankingScale}`">{{avgOverall}}</td>
	      			<td :class="scoreTextClass">Average Rating</td>
	      		</tr>
	      		<br/>
	      		<tr class="md-layout md-alignment-center">
	      			<td :class="`${scoreNumberClass} ${difficultyRankingScale}`">{{avgDifficulty}}</td> 
	      			<td :class="scoreTextClass">Average Difficulty</td>
	      		</tr>
	      	</table>
     	</md-content>
     	<div 
     		v-else 
     		class="md-layout-item md-xsmall-size-100 md-small-size-26 vertical-spacing md-layout text-center"
     	></div>


      <!-- Prof info container -->
      <md-content class="md-layout-item md-xsmall-size-100 vertical-spacing">
      	<h1 class="prof-name">{{prof.name}}</h1>

      	<p class="md-subtitle">Professor of {{department.name}} at <a href="#">{{school.name}} ({{school.nickname}})</a>, {{school.location}}.</p>
      	<div>
      		<a href="#">Submit a correction</a>
      	</div>
      </md-content>

      <!-- School info container -->
      <md-content class="md-layout-item md-xsmall-size-100 vertical-spacing">
      	<h1>{{school.name}}</h1>
      	<p>Located at {{school.location}}.</p>
      	<a v-if="profsInSchool > 0" href="#">
      		Check out {{profsInSchool}} other professors from this school.
      	</a>
      	<md-divider class="divider"></md-divider>
      	<p>Other professors in the department of {{department.name}}.</p>

      	<a v-if="profsInDepartment > 0" href="#">
      		Click to see {{profsInDepartment}} other {{department.name}} professors at this school.
      	</a>
      	<p v-else class="caption">
      		This professor seems to be the only one in this department on the website.
      	</p>
      </md-content>
    </md-card>
</template>

<script>
	export default {
		name: 'ProfessorDetailsCard',
		props: {
			/**
			 * The professor's model
			 * @type {Object}
			 */
			prof: {
				type: Object,
				required: true,
			},

			/**
			 * The professor's school model
			 * @type {Object}
			 */
			school: {
				type: Object,
				required: true,
			},

			/**
			 * The professor's deparment model
			 * @type {Object}
			 */
			department: {
				type: Object,
				required: true,
			},

			/**
			 * The reviews this professor received
			 * @type {Array}
			 */
			ratings: {
				type: Array,
				default: null,
			},
		},
		data() {
			return {
				scoreNumberClass: 'score md-layout-item md-medium-size-20 md-size-50',
				scoreTextClass: 'score-text md-layout-item md-size-50',
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
			/**
			 * Calculate the average of the overall ratings
			 * @return {Number|Null} 
			 */
			avgOverall() {
				if(this.ratings.length > 0) { 
					const total = this.ratings.reduce((accu, rating) => rating.overall_rating + accu, 0);
					return Number(total / this.ratings.length).toFixed(1);
				}

				return null;
			},

			/**
			 * Calculate the average of the difficulty ratings
			 * @return {Number|Null} 
			 */
			avgDifficulty() {
				if(this.ratings.length > 0) {
					const total = this.ratings.reduce((accu, rating) => rating.difficulty_rating + accu, 0);
					return Number(total / this.ratings.length).toFixed(1);
				}

				return null;
			},

			/**
			 * Determine the smiley and text color for the given overall rating
			 * @return {String} 
			 */
			overallRankingScale() {
				const {avgOverall: overall} = this;

				if(overall >= 3.8) {
					return 'text-success';
				}else if(overall > 2.8) {
					return 'text-warning';
				}
				
				return 'text-danger';
			},

			/**
			 * Determine the smiley and text color for the given average difficulty
			 * @return {String} 
			 */
			difficultyRankingScale() {
				const {avgDifficulty: difficulty} = this;

				if(difficulty >= 3.8) {
					return 'text-danger';
				}else if(difficulty > 2.7) {
					return 'text-warning';
				}
				
				return 'text-success';
			},
		},
	};
</script>

<style scoped>
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
	.prof-name {
		margin-bottom: 1em;
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