import axios from 'axios';
import store from './store';

const BASE_URL= 'http://localhost/ratemy/api';

export function loadAllProfessorsData() {
	return axios.get(`${BASE_URL}/prof/fetch`);
}

export function loadAllSchoolsData() {
	return axios.get(`${BASE_URL}/school/fetch`);
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

export function submitLogout() {
	return axios.post(`${BASE_URL}/auth/logout`, null, auth());
}

export function changePassword(data) {
	return axios.post(`${BASE_URL}/auth/pwd/change`, data, auth());
}