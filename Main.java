import java.util.LinkedList;
import java.util.Queue;
import java.util.Scanner;
import java.io.File;
import java.io.IOException;
import java.util.Stack;

/**
 * @author 计161 CJY in School of Computer and Control Engineering in YTU,
 *         数据结构课程设计 Made on 2017-12-15 14:45:38, 
 *         Project's name: Directory's Tree
 */
public class Main {
	static Scanner in = new Scanner(System.in);
	public static final int MAX_Node_Num = 0x3f3f3f;
	public static int filecount = 0;
	public static int directorycount = 0;
	public static int Cnt = 0;
	public static int depth = 0;
	public static int flag = 1;
	public static String ex = "|_";
	public static Stack<String> stack = new Stack<String>();
	public static Queue<String> queue = new LinkedList<String>();
	public static String x = "*";
	static TreeNode[] tn = new TreeNode[MAX_Node_Num];
	public static int TreeNodeNum_Start = 1;
	public static int tmp = 0;
	public static int cnt = 0; // 计数要输出缩进个数

	/**
	 * @param x 文件夹前缀
	 * @param Cnt 记录当前节点的子节点个数
	 * @param Max_Node_Num 最大树节点个数
	 * @param filecount 记录文件个数
	 * @param directorycount 记录文件夹个数
	 * @param depth 初始化深度
	 * @param stack 用栈记录当前文件夹内的的文件等
	 * @param ex 树形表示前缀
	 * @param tmp 临时表示TreeNodeNum
	 * @param currentDepth 表示当前文件树深度
	 * @param TreeNodeNum_Start 表示起始Node节点
	 * @param queue 用队列记录兄弟目录
	 *
	 */
	/**
	 * 
	 * 首先输入一个路径(看做一个节点)，然后判断是否存在该路径,
	 * 如果存在的话，选择要调用的方法，当选择4的时候，将flag置0，结束程序
	 */
	public static void main(String[] args) throws java.lang.NullPointerException, IOException {
		// TODO Auto-generated method stub
		tn[0] = new TreeNode();
		System.out.println("please enter a Path Name:");
		String root = new String(in.nextLine());
		File path = new File(root);
		if (path.exists()) {
			while (true) {
				if (flag == 0)
					break;
				goto_methods(choice(), path);
			}
		} else
			System.out.println("This path doesn't exist!");
		in.close();
		System.out.println("程序结束,欢迎使用");
	}

	/**
	 * @param choice  为choice方法返回的整型值
	 * @param path 输入的访问路径
	 * @throws IOException
	 * 
	 * 通过调用choice方法返回选项值，确定调用的方法
	 */
	public static void goto_methods(int choice, File path) throws IOException {
		// TODO Auto-generated method stub
		switch (choice) {
		case 1:
			print_subTree(path);
			break;
		case 2:
			print_parentTree(path);
			break;
		case 3:
			print_brotherTree(path);
			break;
		default:
			flag = 0;
			break;
		}
	}
	
	/**
	 * @return  返回的整型值作为goto_methods方法的参数
	 */
	private static int choice() {
		// TODO Auto-generated method stub
		String n ;
		int s ;
		while (true) {
			System.out.println("-----------------美丽的分割线------------------");
			System.out.println("|Make a Choice :                              |");
			System.out.println("|1.Print its directory's subtrees.            |");
			System.out.println("|2.Print its parent directory tree.           |");
			System.out.println("|3.Print its brother tree set.                |");	
			System.out.println("|4.Exit.                                      |");
			System.out.println("-----------------美丽的分割线------------------");
			
			n = in.next();
			s = n.charAt(0)-'0';
			if(s >= 1 && s <=4)
				break;
			else
				System.out.println("Your Choice is illegal, plz Enter again.");
		}
		return s;
	}
	
	/**
	 * @param path	手动输入的路径
	 * @throws IOException
	 * 
	 * 输出子目录树(Tree)
	 * 
	 * 该方法通过先判断是否存在以及是否是一个目录，随后调用build_Tree方法，建立一颗文件的多叉搜索树
	 */
	public static void print_subTree(File path) throws IOException {
		// TODO Auto-generated method stub
		if (path.exists()) {
			if (path.isDirectory()) {
				build_Tree(path, depth);
			} else if (path.isFile()) {
				System.out.println(x + ex + path.getName());
				filecount++;
			} else
				System.out.println("Error!");
		} else
			System.out.println("This Path doesn't exist!");
		System.out.println(x + path.getName());
		for (int i = 0; i < filecount + directorycount; i++) {
			tn[i].traverse();
			if (depth < tn[i].getDepth())
				depth = tn[i].getDepth();
		}
		depth++;
		System.out.println("该目录下一共有:" + filecount + "个文件," + directorycount + "个目录, 目录深度为:" + depth);
	}

	/**
	 * @param path 手动输入的路径
	 * 
	 * 输出当前路径的父路径(Stack & Tree)
	 * 
	 * 通过获取路径的父路径，将父路径存入栈中，再以此为路径，求得父路径 存入栈，直至其父路径为null,随后生成一颗树(也可以不这么做),
	 * 出栈栈顶元素，作为树的根节点，然后继续出栈，将其后面的元素作为根节点的子节点。
	 */
	private static void print_parentTree(File path) {
		// TODO Auto-generated method stub
		int cnt = 0;
		int tmp = 0;
		File prepath = path;
		tn[0] = new TreeNode();
		tn[0].setNodeName(path.getName());
		while (path.getParent() != null){
			stack.push(path.getParent());
			if(path.getParent() != null)
				path = new File(path.getParent());
		}
//		判断是否栈空，并将栈中元素纳入树，出栈
		while (!stack.isEmpty()) {
			tmp = cnt;
			tn[++cnt] = new TreeNode();
			tn[cnt].setNodeName(x + stack.peek());
			tn[cnt].setDepth(tmp);
			tn[tmp].addChildNode(tn[cnt]);
			stack.pop();
		}
//		层次遍历各个节点
		for (int i = 0; i < cnt; i++)
			tn[i].traverse();
		for(int i = 0 ; i < cnt ; i++)
			System.out.print("    ");
		if(prepath.isDirectory())
			System.out.println(ex + x +prepath.getPath());
		else
			System.out.println(ex + prepath.getPath());
		System.out.println("该目录的父目录共有:" + cnt +"个" );
	}

	/**
	 * @param path 手动输入的路径
	 * 
	 * 输出该节点的兄弟节点(Queue)
	 * 
	 * 先获取当前路径的父节点，然后通过父节点获取其所有的子节点，并加入队列，获取完当前所有子节点之后，出队所有元素并输出结果。
	 */
	private static void print_brotherTree(File path) {
		// TODO Auto-generated method stub
		if (path.getParent() != null) {
			File newpath = new File(path.getParent());
			String[] str = newpath.list();
			for (int i = 0; i < str.length; i++) {
				File thispath = new File(str[i]);
				if(thispath.getName().equals(path.getName()))
					continue;
				if (thispath.isDirectory()) {
					queue.offer(x + thispath.getName());
				} else {
					queue.offer(thispath.getName());
				}
			}
			System.out.println("This Path's Brother Tree:");
//			当队不为空时，输出队首元素
			while (queue.peek() != null) {
				if (queue.peek() != path.getName()){
					File tmpFile = new File(queue.peek());
					if(tmpFile.isDirectory())
						System.out.println(ex + x + queue.peek());
					else
						System.out.println(ex + queue.peek());
				}
				queue.poll();
			}
		} else
			System.out.println("This path doesn't have Brother Tree!");
	}

	/**
	 * @param path	手动输入的路径
	 * @param depth 构建树的深度(层数)
	 * @throws IOException
	 * 
	 * 构建一颗多叉搜索树(Tree)
	 * 
	 * 首先将输入的path路径作为树的根节点，获取path路径下的所有文件列表，将其路径下的文件和文件夹作为该根节点的子节点，
	 * 记录该节点的节点下标，该节点的父节点下标，以及该节点的深度(层数)，
	 * 如果子节点为目录，则将该节点作为临时的根节点，同时从该节点进行遍历，获取该节点下的文件列表，将其作为目录的子节点，
	 * 同时，记录作为目录的子节点的个数。
	 * 直到所有的节点遍历完毕，当前建立好了一颗多叉搜索树。
	 * 遍历时，通过遍历每个节点，看是否有子节点列表，有的话则将其输出，并继续查找是否有子节点
	 * 遍历时，通过访问度不为0的节点来遍历文件目录，不遍历叶子结点。
	 */
	public static void build_Tree(File path, int depth) throws IOException {
		// TODO Auto-generated method stub
		String[] arr = path.list();
		int currentDepth = depth + 1;
		if (depth == 0) {
			tn[0].setNodeName(x + path.getName());
			tn[0].setDepth(tmp);
		} else {
			tn[TreeNodeNum_Start] = new TreeNode();
			tn[TreeNodeNum_Start].setNodeName(x + path.getName());
			tn[TreeNodeNum_Start].setDepth(depth);
			tn[TreeNodeNum_Start].setSelfId(TreeNodeNum_Start);
			tn[TreeNodeNum_Start].setParentId(tmp);
			tn[tmp].addChildNode(tn[TreeNodeNum_Start]);
			tn[tmp].setCnt(Cnt++);
			tmp = TreeNodeNum_Start;
			Cnt = 0;
			TreeNodeNum_Start++;
		}
		for (int i = 0; i < arr.length; i++) {
			String str = arr[i];
			File file = new File(path.getPath(), str);
			if (file.isDirectory()) {
				directorycount++;
				build_Tree(file.getCanonicalFile(), currentDepth);// 递归调用
			} else {
				tn[TreeNodeNum_Start] = new TreeNode();
				tn[TreeNodeNum_Start].setNodeName(file.getName());
				tn[TreeNodeNum_Start].setDepth(currentDepth);
				tn[TreeNodeNum_Start].setSelfId(TreeNodeNum_Start);
				tn[TreeNodeNum_Start].setParentId(tmp);
				tn[tmp].addChildNode(tn[TreeNodeNum_Start]);
				tn[tmp].setCnt(Cnt++);
				TreeNodeNum_Start++;
				filecount++;
			}
		}
	}
}
