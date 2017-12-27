import java.util.LinkedList;
import java.util.Queue;
import java.util.Scanner;
import java.io.File;
import java.io.IOException;
import java.util.Stack;

/**
 * @author ��161 CJY in School of Computer and Control Engineering in YTU,
 *         ���ݽṹ�γ���� Made on 2017-12-15 14:45:38, 
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
	public static int cnt = 0; // ����Ҫ�����������

	/**
	 * @param x �ļ���ǰ׺
	 * @param Cnt ��¼��ǰ�ڵ���ӽڵ����
	 * @param Max_Node_Num ������ڵ����
	 * @param filecount ��¼�ļ�����
	 * @param directorycount ��¼�ļ��и���
	 * @param depth ��ʼ�����
	 * @param stack ��ջ��¼��ǰ�ļ����ڵĵ��ļ���
	 * @param ex ���α�ʾǰ׺
	 * @param tmp ��ʱ��ʾTreeNodeNum
	 * @param currentDepth ��ʾ��ǰ�ļ������
	 * @param TreeNodeNum_Start ��ʾ��ʼNode�ڵ�
	 * @param queue �ö��м�¼�ֵ�Ŀ¼
	 *
	 */
	/**
	 * 
	 * ��������һ��·��(����һ���ڵ�)��Ȼ���ж��Ƿ���ڸ�·��,
	 * ������ڵĻ���ѡ��Ҫ���õķ�������ѡ��4��ʱ�򣬽�flag��0����������
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
		System.out.println("�������,��ӭʹ��");
	}

	/**
	 * @param choice  Ϊchoice�������ص�����ֵ
	 * @param path ����ķ���·��
	 * @throws IOException
	 * 
	 * ͨ������choice��������ѡ��ֵ��ȷ�����õķ���
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
	 * @return  ���ص�����ֵ��Ϊgoto_methods�����Ĳ���
	 */
	private static int choice() {
		// TODO Auto-generated method stub
		String n ;
		int s ;
		while (true) {
			System.out.println("-----------------�����ķָ���------------------");
			System.out.println("|Make a Choice :                              |");
			System.out.println("|1.Print its directory's subtrees.            |");
			System.out.println("|2.Print its parent directory tree.           |");
			System.out.println("|3.Print its brother tree set.                |");	
			System.out.println("|4.Exit.                                      |");
			System.out.println("-----------------�����ķָ���------------------");
			
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
	 * @param path	�ֶ������·��
	 * @throws IOException
	 * 
	 * �����Ŀ¼��(Tree)
	 * 
	 * �÷���ͨ�����ж��Ƿ�����Լ��Ƿ���һ��Ŀ¼��������build_Tree����������һ���ļ��Ķ��������
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
		System.out.println("��Ŀ¼��һ����:" + filecount + "���ļ�," + directorycount + "��Ŀ¼, Ŀ¼���Ϊ:" + depth);
	}

	/**
	 * @param path �ֶ������·��
	 * 
	 * �����ǰ·���ĸ�·��(Stack & Tree)
	 * 
	 * ͨ����ȡ·���ĸ�·��������·������ջ�У����Դ�Ϊ·������ø�·�� ����ջ��ֱ���丸·��Ϊnull,�������һ����(Ҳ���Բ���ô��),
	 * ��ջջ��Ԫ�أ���Ϊ���ĸ��ڵ㣬Ȼ�������ջ����������Ԫ����Ϊ���ڵ���ӽڵ㡣
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
//		�ж��Ƿ�ջ�գ�����ջ��Ԫ������������ջ
		while (!stack.isEmpty()) {
			tmp = cnt;
			tn[++cnt] = new TreeNode();
			tn[cnt].setNodeName(x + stack.peek());
			tn[cnt].setDepth(tmp);
			tn[tmp].addChildNode(tn[cnt]);
			stack.pop();
		}
//		��α��������ڵ�
		for (int i = 0; i < cnt; i++)
			tn[i].traverse();
		for(int i = 0 ; i < cnt ; i++)
			System.out.print("    ");
		if(prepath.isDirectory())
			System.out.println(ex + x +prepath.getPath());
		else
			System.out.println(ex + prepath.getPath());
		System.out.println("��Ŀ¼�ĸ�Ŀ¼����:" + cnt +"��" );
	}

	/**
	 * @param path �ֶ������·��
	 * 
	 * ����ýڵ���ֵܽڵ�(Queue)
	 * 
	 * �Ȼ�ȡ��ǰ·���ĸ��ڵ㣬Ȼ��ͨ�����ڵ��ȡ�����е��ӽڵ㣬��������У���ȡ�굱ǰ�����ӽڵ�֮�󣬳�������Ԫ�ز���������
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
//			���Ӳ�Ϊ��ʱ���������Ԫ��
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
	 * @param path	�ֶ������·��
	 * @param depth �����������(����)
	 * @throws IOException
	 * 
	 * ����һ�Ŷ��������(Tree)
	 * 
	 * ���Ƚ������path·����Ϊ���ĸ��ڵ㣬��ȡpath·���µ������ļ��б�����·���µ��ļ����ļ�����Ϊ�ø��ڵ���ӽڵ㣬
	 * ��¼�ýڵ�Ľڵ��±꣬�ýڵ�ĸ��ڵ��±꣬�Լ��ýڵ�����(����)��
	 * ����ӽڵ�ΪĿ¼���򽫸ýڵ���Ϊ��ʱ�ĸ��ڵ㣬ͬʱ�Ӹýڵ���б�������ȡ�ýڵ��µ��ļ��б�������ΪĿ¼���ӽڵ㣬
	 * ͬʱ����¼��ΪĿ¼���ӽڵ�ĸ�����
	 * ֱ�����еĽڵ������ϣ���ǰ��������һ�Ŷ����������
	 * ����ʱ��ͨ������ÿ���ڵ㣬���Ƿ����ӽڵ��б��еĻ���������������������Ƿ����ӽڵ�
	 * ����ʱ��ͨ�����ʶȲ�Ϊ0�Ľڵ��������ļ�Ŀ¼��������Ҷ�ӽ�㡣
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
				build_Tree(file.getCanonicalFile(), currentDepth);// �ݹ����
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
