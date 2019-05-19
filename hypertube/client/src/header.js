import React, { Component } from "react";
import { withRouter } from "react-router";
import { Navbar, Nav, Button, Image} from "react-bootstrap";

import "./css/header.css";

import Img_logo from "./medias/logo.png"
import Img_profile from "./scrim/medias/profile.jpg"
import Img_chevron from "./scrim/medias/chevron.png"
import Img_nf from "./scrim/medias/newfriend.png"

class Header extends Component {

	constructor(props) {
		super(props);

		this.state = {
			"color": "transparent"
		};
	}

	state = {
		color: 'transparent'
	}

	listenScrollEvent = e => {
		if (window.scrollY > 110) {
			this.setState({"color": "#000"});
		} else {
			this.setState({"color": "transparent"});
		}
	}

	componentDidMount() {
		window.addEventListener('scroll', this.listenScrollEvent);
	}

	componentWillUnmount() {
		window.removeEventListener("scroll", this.listenScrollEvent);
	}

	render() {
		return (
			<div>
				<Navbar className="h_navbar" style={{backgroundColor: this.state.color}} collapseOnSelect expand="sm" variant="dark" fixed="top">
					<Navbar.Brand href="#" onClick={ () => { this.props.history.push("/scrim/profile") }}>
						<b style={{ color:'#fff', fontSize:'20px' }}><img src={Img_logo} width="48px" />{" SCRIM.GG "}</b>
					</Navbar.Brand>
					<Navbar.Toggle aria-controls="responsive-navbar-nav"/>
					<Navbar.Collapse id="responsive-navbar-nav">
						<Nav.Link className="h_link" onClick={() => this.props.history.push("/scrim/profile")}>Scrims</Nav.Link>
						<Nav.Link className="h_link" onClick={() => this.props.history.push("/scrim/profile")}>Search and find</Nav.Link>
						<Navbar.Collapse className="justify-content-end" >
							<div className="h_cont_imgs">
								<Image className="h_img_nf" height="22" width="22" src={ Img_nf } />
								<input id="h_cont_input" class="form-control mr-sm-2" type="text" placeholder="Search"/>
								</div>
							<div className="h_cont_right">
								<Image className="h_img_pro" height="42" width="42" src={ Img_profile } roundedCircle />
								<img className="h_img_che" height="35" width="35" src={ Img_chevron } />
							</div>
						</Navbar.Collapse>
					</Navbar.Collapse>
				</Navbar>
			</div>
		);
	}
}

export default withRouter(Header);
