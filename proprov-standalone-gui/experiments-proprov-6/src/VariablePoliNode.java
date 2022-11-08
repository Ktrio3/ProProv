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
import java.util.LinkedList;

import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.layout.Pane;

public class VariablePoliNode extends PoliNode{
	
	private PolicyPoliNode parent;
	private PoliNode leftSibling;
	private TextField tf;
	private int xPos;
	private int mod;
	private int yPos;
	private Label policyLabel;
	

	
	public VariablePoliNode(PolicyPoliNode parent, Label policyLabel) {
		this.parent = parent;
		leftSibling = null;
		this.policyLabel = policyLabel;
		tf = new TextField();
		tf.setPromptText("< variable >");
		tf.setStyle("-fx-background-color: white; -fx-font-size: 20;  -fx-pref-width: 250; -fx-border-color: red; -fx-border-style: solid; -fx-border-width: 3px 3px");
		listenForChangedValue();
	}

		
	public TextField getNode() {
		return tf;
	}


	@Override
	public void setX(int xPos) {
		this.xPos = xPos;
	}


	@Override
	public int getX() {
		return xPos;
	}


	@Override
	public void setY(int yPos) {
		this.yPos = yPos;
	}


	@Override
	public int getY() {
		return yPos;
	}


	@Override
	public void setMod(int mod) {
		this.mod = mod;
	}


	@Override
	public int getMod() {
		return mod;
	}


	@Override
	public void draw(Pane pane) {
		int x = getX();
		int y = getY();
		tf.setLayoutX(x);
		tf.setLayoutY(y);
		pane.getChildren().add(tf);
	}


	@Override
	public PoliNode getLeftSibling() {
		return null;
	}


	@Override
	public LinkedList<PoliNode> getChildren() {
		// TODO Auto-generated method stub
		return new LinkedList<PoliNode>();
	}


	@Override
	public PolicyPoliNode getParent() {
		// TODO Auto-generated method stub
		return parent;
	}
	
	@Override
	public int getNodeHeight() {
		return (int)tf.getHeight();
	}
	
	@Override
	public int getNodeWidth() {
		return (int) tf.getWidth();
	}
	
	//listen for user to type variable name
		//set variable for policy of parent node
	private void listenForChangedValue() {
		tf.textProperty().addListener((observable, oldValue, newValue) -> {
			QuantifiedPolicy qp = (QuantifiedPolicy) parent.getPolicy();
			qp.setVariable(newValue);
			tf.setStyle("-fx-background-color: white; -fx-font-size: 20;  -fx-pref-width: 250; -fx-border-color: green; -fx-border-style: solid; -fx-border-width: 3px 3px");
			policyLabel.setText(getTreeRoot(this).getPolicy().toString());
		});
	}
	
	public PolicyPoliNode getTreeRoot(PoliNode node) {
		while(node.getParent()!= null) {
			node = node.getParent();
		}
		
		return (PolicyPoliNode) node;
	}


}
