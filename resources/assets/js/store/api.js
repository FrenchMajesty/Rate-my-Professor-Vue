import axios from 'axios';
import $ from 'jquery';
import store from './store';

const BASE_URL= 'http://localhost/ratemy/api';

export function loadAllProfessorsData() {
	return axios.get(`${BASE_URL}/prof/fetch`);
}

export function loadAllSchoolsData() {
	return axios.get(`${BASE_URL}/school/fetch`);
}

export function loadAllDeptsData() {
	return axios.get(`${BASE_URL}/department/fetch`);
}

export function loadAllReviewTags() {
	return axios.get(`${BASE_URL}/prof/review/tags`, auth());
}

export function loadProfessorReviews(params) {
	return axios.get(`${BASE_URL}/prof/review/fetch?${$.param(params)}`);
}

export function submitStudentRegistration(data) {
	return axios.post(`${BASE_URL}/auth/signup/student`, data);
}

export function submitProfRegistration(data) {
	return axios.post(`${BASE_URL}/auth/signup/prof`, data);
}

export function submitLogin(data) {
	return axios.post(`${BASE_URL}/auth/login`, data);
}

const auth = () => {
	const {accessToken} = store.state.auth;
	return { headers: { Authorization: `Bearer ${accessToken}` } };
};

export function loadUserData() {
	return axios.get(`${BASE_URL}/user`, auth());
} 

export function updateUserData(data) {
	const {id} = store.state.user;
	return axios.put(`${BASE_URL}/profile/${id}`, data, auth());
} 

export function submitLogout() {
	return axios.post(`${BASE_URL}/auth/logout`, null, auth());
}

export function changePassword(data) {
	return axios.post(`${BASE_URL}/auth/pwd/change`, data, auth());
}

export function createProfessorReview(data) {
	return axios.post(`${BASE_URL}/prof/review`, data, auth());
}


