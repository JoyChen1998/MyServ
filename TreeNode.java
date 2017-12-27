import java.util.List;  
import java.util.ArrayList;  
import java.io.Serializable;  
  
/**
 * @author 计161 CJY in School of Computer and Control Engineering in YTU,
 *         数据结构课程设计 Made on 2017-12-15 14:50:21, 
 *         Project's name: Directory's Tree
 *
 */
public class TreeNode implements Serializable {  
    private int parentId;  
    private int selfId;
    private int depth = 0;
    private String space = "    ";
    private String ex = "_";
	private String ex1 = "|";
	private int cnt = 0;
    protected String nodeName;   
    protected TreeNode parentNode;  
    protected List<TreeNode> childList;
    public TreeNode() {  
        initChildList();  
    }  
  
    public TreeNode(TreeNode parentNode) {  
        this.getParentNode();  
        initChildList();  
    }  
  
    public boolean isLeaf() {  
        if (childList == null) {  
            return true;  
        } else {  
            if (childList.isEmpty()) {  
                return true;  
            } else {  
                return false;  
            }  
        }  
    }  
  
    /* 插入一个child节点到当前节点中 */  
    public void addChildNode(TreeNode treeNode) {  
        initChildList();  
        childList.add(treeNode);  
    }  
  
    public void initChildList() {  
        if (childList == null)  
            childList = new ArrayList<TreeNode>();  
    }  
  
    /* 返回当前节点的父辈节点集合 */  
    public List<TreeNode> getElders() {  
        List<TreeNode> elderList = new ArrayList<TreeNode>();  
        TreeNode parentNode = this.getParentNode();  
        if (parentNode == null) {  
            return elderList;  
        } else {  
            elderList.add(parentNode);  
            elderList.addAll(parentNode.getElders());  
            return elderList;  
        }  
    }  
  
    /* 返回当前节点的晚辈集合 */  
    public List<TreeNode> getJuniors() {  
        List<TreeNode> juniorList = new ArrayList<TreeNode>();  
        List<TreeNode> childList = this.getChildList();  
        if (childList == null) {  
            return juniorList;  
        } else {  
            int childNumber = childList.size();  
            for (int i = 0; i < childNumber; i++) {  
                TreeNode junior = childList.get(i);  
                juniorList.add(junior);  
                juniorList.addAll(junior.getJuniors());  
            }  
            return juniorList;  
        }  
    }  
  
    /* 返回当前节点的孩子集合 */  
    public List<TreeNode> getChildList() {  
        return childList;  
    }  
  
    /* 删除节点和它下面的晚辈 */  
    public void deleteNode() {  
        TreeNode parentNode = this.getParentNode();  
        int id = this.getSelfId();    
        if (parentNode != null) {  
            parentNode.deleteChildNode(id);  
        }  
    }  
  
    /* 删除当前节点的某个子节点 */      
    public void deleteChildNode(int childId) {  
        List<TreeNode> childList = this.getChildList();  
        int childNumber = childList.size();  
        for (int i = 0; i < childNumber; i++) {  
            TreeNode child = childList.get(i);  
            if (child.getSelfId() == childId) {  
                childList.remove(i);  
                return;  
            }  
        }  
    }  
  
    /* 动态的插入一个新的节点到当前树中 */  
    public boolean insertJuniorNode(TreeNode treeNode) {  
        int juniorParentId = treeNode.getParentId();  
        if (this.parentId == juniorParentId) {  
            addChildNode(treeNode);  
            return true;  
        } else {  
            List<TreeNode> childList = this.getChildList();  
            int childNumber = childList.size();  
            boolean insertFlag;  
            for (int i = 0; i < childNumber; i++) {  
                TreeNode childNode = childList.get(i);  
                insertFlag = childNode.insertJuniorNode(treeNode);  
                if (insertFlag == true)  
                    return true;  
            }  
            return false;  
        }  
    }  
  
    /* 找到一颗树中某个节点 */  
    public TreeNode findTreeNodeById(int id) {  
        if (this.selfId == id)  
            return this;  
        if (childList.isEmpty() || childList == null) {  
            return null;  
        } else {  
            int childNumber = childList.size();  
            for (int i = 0; i < childNumber; i++) {  
                TreeNode child = childList.get(i);  
                TreeNode resultNode = child.findTreeNodeById(id);  
                if (resultNode != null) {  
                    return resultNode;  
                }  
            }  
            return null;  
        }  
    }  
  
    /* 遍历一棵树,层次遍历,以及输出节点数*/  
    public void traverse() {
        if (selfId < 0)  
            return;  
        if (childList == null || childList.isEmpty())  
            return;  
        int childNumber = childList.size();  
        for (int i = 0; i < childNumber; i++) {  
            TreeNode child = childList.get(i);
            for(int j = 0 ;j < child.depth; j++)
            	System.out.print(space+ex1);
            System.out.println(ex+child.getNodeName());
        }  
    } 
  
    public int getParentId() {  
        return parentId;  
    }  
    public void setDepth(int depth){
    	this.depth = depth;
    }
    public int getDepth(){
    	return depth;
    }
    public void setParentId(int parentId) {  
        this.parentId = parentId;  
    }  
  
    public int getSelfId() {  
        return selfId;  
    }  
   
    public void setSelfId(int selfId) {  
        this.selfId = selfId;  
    }  
  
    public TreeNode getParentNode() {  
        return parentNode;  
    }  
  
    public void setParentNode(TreeNode parentNode) {  
        this.parentNode = parentNode;  
    }  
  
    public String getNodeName() {  
        return nodeName;  
    }  
    public void setNodeName(String nodeName) {  
        this.nodeName = nodeName;  
    }  
    
    public void setCnt(int cnt){
    	this.cnt = cnt;
    }
    public int getCnt(){
    	return cnt;
    }
}