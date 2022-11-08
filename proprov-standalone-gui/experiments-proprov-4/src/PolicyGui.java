/*
* DISTRIBUTION STATEMENT A. Approved for public release. Distribution is unlimited.
* This material is based upon work supported by the Under Secretary of Defense for Research and Engineering 
* under Air Force Contract No. FA8702-15-D-0001. Any opinions, findings, conclusions or recommendations 
* expressed in this material are those of the author(s) and do not necessarily reflect the views of the 
* Under Secretary of Defense for Research and Engineering.
* 
* © 2021 Massachusetts Institute of Technology.
* 
* The software/firmware is provided to you on an As-Is basis
* Delivered to the U.S. Government with Unlimited Rights, as defined in DFARS Part 252.227-7013 or 
* 7014 (Feb 2014). Notwithstanding any copyright notice, U.S. Government rights in this work are defined 
* by DFARS 252.227-7013 or DFARS 252.227-7014 as detailed above. Use of this work other than as specifically 
* authorized by the U.S. Government may violate any copyrights that exist in this work.
* 
* RAMS # 1017050
*/
import java.util.ArrayList;
import java.util.List;

import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Group;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.Pane;
import javafx.scene.layout.VBox;
import javafx.stage.Modality;
import javafx.stage.Stage;

public class PolicyGui extends BorderPane{
	
	private Label policyLabel;
	private Pane pane;
	private ScrollPane sp;
	private ScrollPane bsp;
	private VBox bVbox;
	private Button eval;

	public PolicyGui() {
		
		pane = new Pane();
		pane.setMinSize(1800, 1800);
		pane.setPadding(new Insets(10,10,10,10));
		pane.setStyle("-fx-background-color: dimgrey");
		
		Group group = new Group();
		group.setStyle("-fx-background-color: black");
		group.getChildren().add(pane);
		
		//gui scroll pane
		sp = new ScrollPane();
		sp.setPrefViewportHeight(400);
		sp.setPrefViewportWidth(400);
		sp.setContent(group);
		sp.setHbarPolicy(ScrollPane.ScrollBarPolicy.ALWAYS);
		sp.setVbarPolicy(ScrollPane.ScrollBarPolicy.ALWAYS);
		sp.setPannable(true);
		sp.setFitToWidth(false);
		sp.setFitToHeight(false);
		sp.setStyle("-fx-background-color: black");
		setCenter(sp);
		
		//label for policy at bottom of screen
		policyLabel = new Label();
		policyLabel.setStyle("-fx-font: 45px Arial");
		policyLabel.setText("<policy>");
		policyLabel.setMaxWidth(getMaxWidth());
		policyLabel.setPadding(new Insets(10,10,20,10));
		eval = new Button("Evaluate");
		eval.setStyle("-fx-font: 30px Arial; -fx-background-radius: 8,7,6; -fx-background-insets: 0,1,2; -fx-text-fill: black;-fx-effect: dropshadow(three-pass-box, rgba(0,0,0,0.6),5,0.0,0,1)");
		eval.setMaxWidth(Double.MAX_VALUE);
		
		bVbox = new VBox(10);
		bVbox.getChildren().addAll(policyLabel,eval);
		
		bsp = new ScrollPane();
		bsp.setContent(bVbox);
		bsp.setHbarPolicy(ScrollPane.ScrollBarPolicy.AS_NEEDED);
		bsp.setFitToWidth(false);
		bsp.setFitToHeight(false);
		bsp.setStyle("-fx-background-color: white");
		setBottom(bsp);
	
		
		task4();
		
	}
	
	private void task4() {
		
		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Filter", "activity");
		pg1.addVertex("Students#usf", "dataEntity");
		pg1.addEdge("Filter", "used", "Students#usf");
		
		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("Map", "activity");
		pg2.addVertex("Students#usf", "dataEntity");
		pg2.addEdge("Map", "used", "Students#usf");
		
		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("Filter", "activity");
		pg3.addVertex("CareerFairAttendees#org", "dataEntity");
		pg3.addEdge("Filter", "used", "CareerFairAttendees#org");
		
		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");
		
		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Registrar#usf");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		//create root of policy tree
		PolicyPoliNode root = new PolicyPoliNode(null,null,pane,policyLabel);
		root.setX(100);
		root.setY(100);
		root.draw(pane);
		
		eval.setOnAction(e ->{
			Policy p = root.getPolicy();
			
			if(!checkIncompletePolicy(p)) {
				boolean r1 = p.evaluate(pg1);
				boolean r2 = p.evaluate(pg2);
				boolean r3 = p.evaluate(pg3);
				boolean r4 = p.evaluate(pg4);
				boolean r5 = p.evaluate(pg5);
				List<String> errors = new ArrayList<>();
				
				if(!r1) {
					errors.add("Graph 1 should satisfy your policy");
				}
				if(!r2) {
					errors.add("Graph 2 should satisfy your policy");
				}
				if(r3) {
					errors.add("Graph 3 should violate your policy");
				}
				if(!r4) {
					errors.add("Graph 4 should satisfy your policy");
				}
				if(r5) {
					errors.add("Graph 5 should violate your policy");
				}
				
				Label label = new Label();
				label.setPadding(new Insets(10,10,10,10));
				label.setStyle("-fx-font:20px Arial");
				
				if(!errors.isEmpty()) {
					for(String s: errors) {
						System.out.println("Unexpected result: " + s);
					}
				}else {
					System.out.println("Correct!");
				}					
			
			}else {
				System.out.println("The policy is incomplete");
			}
		});
	}
	
	private boolean checkIncompletePolicy(Policy p) {
		if(p instanceof EdgePolicy) {
			if(((EdgePolicy)p).getSrc() == null || ((EdgePolicy)p).getDst() == null){
				return true;
			}
		}else if(p instanceof NegationPolicy) {
			return checkIncompletePolicy(((NegationPolicy)p).getPolicy());
		}else if(p instanceof BinaryPolicy) {
			return checkIncompletePolicy(((BinaryPolicy)p).getLeftPolicy()) && checkIncompletePolicy(((BinaryPolicy)p).getRightPolicy());
		}else if(p instanceof QuantifiedPolicy) {
			if(((QuantifiedPolicy)p).getVariable() == null || ((QuantifiedPolicy)p).getType() == null) {
				return true;
			}
			return checkIncompletePolicy(((QuantifiedPolicy)p).getPolicy());
		}else if(p == null) {
			return true;
		}
		
		return false;
	}
}
