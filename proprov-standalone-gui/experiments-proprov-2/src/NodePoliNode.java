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

import javafx.collections.FXCollections;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.layout.Pane;

public class NodePoliNode extends PoliNode{
	
	private ComboBox<String> cb;
	private PolicyPoliNode parent;
	private NodePoliNode leftSibling;
	private int xPos;
	private int mod;
	private int yPos;
	private Policy policy;
	private boolean isLeftNode = false;
	
	
	
	public NodePoliNode(PolicyPoliNode parent, String[] nodeOptions, NodePoliNode leftSibling, Label policyLabel) {
		this.parent = parent;
		this.leftSibling = leftSibling;
		
		cb = new ComboBox<>();
		cb.setPromptText("< node >");
		cb.setEditable(true);
		cb.getItems().addAll(FXCollections.observableArrayList(nodeOptions));
		cb.setStyle("-fx-background-color: white; -fx-font-size: 20;  -fx-pref-width: 250; -fx-border-color: red; -fx-border-style: solid; -fx-border-width: 3px 3px");
		cb.setOnAction(e ->{
			cb.setStyle("-fx-background-color: white; -fx-font-size: 20;  -fx-pref-width: 250; -fx-border-color: green; -fx-border-style: solid; -fx-border-width: 3px 3px");
			EdgePolicy ep = (EdgePolicy) this.parent.getPolicy();
			if(getIsLeftNode()) {
				ep.setSrc(cb.getValue());
			}else {
				ep.setDst(cb.getValue());
			}
			policyLabel.setText(getTreeRoot(this).getPolicy().toString());
		});
	}

	
	
	public ComboBox<String> getNode(){
		return cb;
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
	
	public NodePoliNode getLeftSibling() {
		return leftSibling;
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
		cb.setLayoutX(x);
		cb.setLayoutY(y);
		pane.getChildren().add(cb);
		
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
		return (int)cb.getHeight();
	}



	@Override
	public int getNodeWidth() {
		return (int) cb.getWidth();
	}
	
	public void setIsLeftNode() {
		isLeftNode = true;
	}
	
	public boolean getIsLeftNode() {
		return isLeftNode;
	}
	
	public PolicyPoliNode getTreeRoot(PoliNode node) {
		while(node.getParent() != null) {
			node = node.getParent();
		}
		
		return (PolicyPoliNode) node;
	}


}
