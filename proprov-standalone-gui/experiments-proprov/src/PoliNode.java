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

import javafx.scene.layout.Pane;

public abstract class PoliNode {
	
	public abstract void setX(int xPos);
	public abstract int getX();
	public abstract void setY(int yPos);
	public abstract int getY();
	public abstract void setMod(int mod);
	public abstract int getMod();
	public abstract void draw(Pane pane);
	public abstract PoliNode getLeftSibling();
	public abstract LinkedList<PoliNode> getChildren();
	public abstract PolicyPoliNode getParent();
	public abstract int getNodeHeight();
	public abstract int getNodeWidth();

}
