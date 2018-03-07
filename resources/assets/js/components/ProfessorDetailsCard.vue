<template>
	<md-card class="md-layout md-gutter no-margin padding-above text-align-sm">
		<!-- Ratings container -->
      	<md-content class="md-layout-item md-xsmall-size-100 md-small-size-26 vertical-spacing md-layout text-center">
	      	<md-content class="md-layout-item md-size-100 smiley-container">
	      		<md-icon :class="'md-size-4x '+overallRankingScale">tag_faces</md-icon>
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

      <!-- Prof info container -->
      <md-content class="md-layout-item md-xsmall-size-100 vertical-spacing">
      	<h1 class="prof-name">{{prof.name}}</h1>

      	<p class="md-subtitle">Professor of {{departmentName}} at <a href="#">{{prof.school.name}}</a>, {{prof.school.location}}.</p>
      	<div>
      		<a href="#">Submit a correction</a>
      	</div>
      </md-content>

      <!-- School info container -->
      <md-content class="md-layout-item md-xsmall-size-100 vertical-spacing">
      	<h1>{{prof.school.name}}</h1>
      	<p>Located at {{prof.school.location}}.</p>
      	<a v-if="numberOfSimilarProfs.school > 0" href="#">
      		Check out {{numberOfSimilarProfs.school}} other professors from this school.
      	</a>
      	<md-divider class="divider"></md-divider>
      	<p>Other professors in the deparment of {{departmentName}}.</p>

      	<a v-if="numberOfSimilarProfs.department > 0" href="#">
      		Click to see {{numberOfSimilarProfs.department}} other {{departmentName}} professors at this school.
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
			prof: {
				type: Object,
				required: true,
			},
			numberOfSimilarProfs: {
				type: Object,
				required: true,
			},
		},
		data() {
			return {
				scoreNumberClass: 'score md-layout-item md-medium-size-20 md-size-50',
				scoreTextClass: 'score-text md-layout-item md-size-50',
			};
		},
		computed: {
			departmentName() {
				return this.prof.department.name.toLowerCase();
			},
			avgOverall() {
				return 3.3;
			},
			avgDifficulty() {
				return 4.6;
			},
			overallRankingScale() {
				const {avgOverall: overall} = this;

				if(overall >= 3.8) {
					return 'text-success';
				}else if(overall > 2.8) {
					return 'text-warning';
				}else {
					return 'text-danger';
				}
			},
			difficultyRankingScale() {
				const {avgDifficulty: difficulty} = this;

				if(difficulty >= 3.8) {
					return 'text-danger';
				}else if(difficulty > 2.7) {
					return 'text-warning';
				}else {
					return 'text-success';
				}
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