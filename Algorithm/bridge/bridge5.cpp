#include <iostream>
#include <fstream>
#include <queue>
#include <time.h>
#include <stdlib.h>
#include <iomanip>
using namespace std;

#define MAX 500
#define FILE_PATH "res.txt" //测试文件生成路径 
//const int SLEEP_TIME = 100;
//ms 每次测试的间歇中断时间 防止时间函数出错

const int TEST_MAP_NUM = 10;//一共生成 多少个图
const int TEST_TIMES = 2;//每个测试图的运行次数
const int EDGE_MUL = 3;//随机生成的边数据是点数目的最大倍数

const bool ECHO_CREATE_MAP = true;
//输出产生的图节点和边信息

const bool ECHO_BRIDGE_RES = false;
//输出找到的的桥数据

const bool ECHO_EACH_EXC_TIME = false;
//输出每次测试的单独运行时间结果

const bool ECHO_KRU_RES_MX = false;
//输出每次 kruskal构造树，进行环边标记之后的邻接矩阵。标记为2的就是环边

const bool ECHO_AFTER_SORT_EDGE = false;
//输出每次 kruskal构造树.生成连通分量之前的边排序结果

const bool ECHO_KRU_CONNECTED = false;
//输出每次构造树的连接过程

const bool ECHO_BFS_NODE = false;
//计算连通数的时候，输出 广度优先遍历序列

/*产生区间[a,b]上的随机数*/
inline int getRand(int a ,int b) {

	return (int) ( ((double)rand()/RAND_MAX)*(b-a) + a);
};

class CloseE { //相近边对象
	public:
		int vi;//进入边
		int vo;//出去边
		int cost;

		CloseE() {
			vi = -1;
			vo = -1;
			cost = 9999;
		}


		void set(int vi,int vo ,int c) {
			this->vi = vi;
			this->vo = vo;
			cost = c;
		}
};


class Map { //输入的图
	public:
		bool visit[MAX];//是否已经被访问
		int map_mx[MAX][MAX];//节点从0开始
		int node_num;//节点从0开始
		void BFS(int v);//广度优先搜索

		void init(int vnum,int **mx);
		int getConnectedNum();
		int removeEach(bool isEcho);//基准算法
		bool kruskal() ;//最大生成树标记环边
		int setCircle(int edge_num,bool isEcho);//设置环边

		//并查集合并操作
		void mergeSet(int set1,int set2,int node_id[]) {
			int i;
			for(i=0; i<node_num; i++) {
				if(node_id[i] == set2) {
					node_id[i] = set1;
				}
			}
		}

		void echo() {
			int i,j;
			//mx echo
			for(i=0; i<node_num; i++) {
				for(j=0; j<node_num; j++) {
					cout<<map_mx[i][j]<<" ";
				}
				cout<<endl;
			}
			cout<<endl;
		}

};


bool Map::kruskal() {//有副作用 会直接把原本的连接阵边权改掉
	int i,j,num,set_id,max_index ;
	//边的权值大过1的表示是环上的边

	int node_id[MAX];//并查集标号 初始化是0
	for(i=0; i<node_num; i++) {
		node_id[i] = 0;
	}

	//key 表示节点id ，value 表示所属的集合id

	CloseE close[MAX];
	CloseE e;


	int max = 0;


	//边的对象数组
	for(i=0,num=0; i<node_num-1; i++) {
		for(j=i+1; j<node_num; j++) {//无向图 对称结构
			if(map_mx[i][j]>0) {
				close[num].set(i,j,map_mx[i][j]);
				num++;
			}
		}
	}

//	cout<<"num:"<<num<<endl;

	//做一个边对象数组的选择排序 把大的边放到前面
	//先去用环边生成 这样更容易找到其他环边
	for(i=0; i<num-1; i++) {
		max_index = i;
		for(j=max_index+1; j<num; j++) {
			if(close[j].cost > close[max_index].cost) {
				max_index = j;
			}
		}

		if(max_index != i) {

			e.set(close[max_index].vi,close[max_index].vo,close[max_index].cost);

			close[max_index].set(close[i].vi,close[i].vo,close[i].cost);
			close[i].set(e.vi,e.vo,e.cost);
		}
	}

	if(ECHO_AFTER_SORT_EDGE) {
		cout<<"after sort"<<endl;
		for(i=0; i<num; i++) {
			cout<<"vi--"<<close[i].vi<<" ";
			cout<<"vo--"<<close[i].vo<<" ";
			cout<<"cost--"<<close[i].cost<<endl;
		}
	}

	//开始一个个添加边 最小生成树的目的是为了找到环的边
	bool found_circle = false;
	int connected = 0;
	for(i=0,set_id = 1; i<num; i++) {

		//已经连满了 但是让其继续找环边
//		if(connected >= node_num-1) {
//			break;
//		}

		int vi = close[i].vi;
		int vo = close[i].vo;
		int cost = close[i].cost;

//				cout<< vi <<" "<< vo <<" "<< cost <<endl;

		//根据这个边的两个点情况 判断加入哪个并查集
		if(!node_id[vi] && !node_id[vo]) {//都是还没连接的点
			node_id[vi] =  node_id[vo] = set_id; //合并到一个联通分量里
			set_id++; //下一个并合集序号

			connected++;

			if(ECHO_KRU_CONNECTED) cout<< vi <<" "<<vo<<" "<< "connected" <<endl;

		} else if( !node_id[vi] && node_id[vo]) {//没连的那个点 接入另一个点连到的set里
			node_id[vi] = node_id[vo];
			connected++;
			if(ECHO_KRU_CONNECTED) cout<< vi <<" "<<vo<<" "<< "connected" <<endl;

		} else if( node_id[vi] && !node_id[vo]) {////没连的那个点 接入另一个点连到的set里
			node_id[vo] = node_id[vi];
			connected++;
			if(ECHO_KRU_CONNECTED) cout<< vi <<" "<<vo<<" "<< "connected" <<endl;

		} else { //两个都有set

			//相同的set 说明有环
			if(node_id[vi] ==  node_id[vo]) {
				if(map_mx[vi][vo] == 1) {
					found_circle = true;
					map_mx[vi][vo]++;
					map_mx[vo][vi]++; //把环上的边权重增加
				}
				if(ECHO_KRU_CONNECTED) 	cout<<"no connected " <<endl;
				continue;
			}
			//不同的集合 进行一个合并
			mergeSet(node_id[vi],node_id[vo],node_id);
			if(ECHO_KRU_CONNECTED) cout<< vi <<" "<<vo<<" "<< "connected" <<endl;
			set_id++;//下一个并合集序号
			connected++;
		}
	}//for i


	return found_circle;
}


int Map::removeEach(bool isEcho = true) {
	int i,j,c1,c2;
	c1 = getConnectedNum();
//	cout<<"c1:"<<c1<<endl;
	//-1位即桥
	int num = 0;
	for(i=0; i<node_num-1; i++) {//遍历每个边
		for(j=i+1; j<node_num; j++) {//矩阵对称结构
			//todo 试着去除一条边
			if(map_mx[i][j]==1) { //假设是桥 置位-1
				map_mx[i][j] = -1;
				map_mx[j][i] = -1;
				c2 = getConnectedNum();
//				cout<<"c2:"<<c2<<endl;
				if(c2!=c1) {//找到桥
					num++;

					if(isEcho) {//输出
						cout<<"bridge["<<num<<"]:";
						cout<<i<<" "<<j<<endl;
					}
				}
				//之后还原
				map_mx[i][j] = 1;
				map_mx[j][i] = 1;

			}
		}
	}


	if(num==0 && isEcho) {
		cout<<"no bridge"<<endl;
	}

	return num;

}

int Map::getConnectedNum() {//连同分量个数
	int i,connected=0;

	//mx echo
//	for(i=0; i<node_num; i++) {
//		for(j=0; j<node_num; j++) {
//			cout<<map_mx[i][j];
//		}
//		cout<<endl;
//	}

//每次算之前记得先重置一次访问数组
	for(i=0; i<node_num; ++i) {
		visit[i]=false;
	}

	for(i=0; i<node_num; ++i) {
		if(!visit[i]) {
			BFS(i);//广度优先搜索去遍历
			connected++;
		}
	}
	return connected;
}

void Map::BFS(int v) {

	if(ECHO_BFS_NODE) cout<<"BFS:"<<v<<" ";

	visit[v]=true;
	queue<int> Q;

	for(int i=0; i<node_num; i++) {
		if(map_mx[v][i] > 0
		        &&!visit[i]) {//相连接 并且没有访问过的的点
			Q.push(i);
		}
	}

	while(!Q.empty()) {
		BFS(Q.front());
		Q.pop();
	}
}

//找出大部分的环边
int Map::setCircle(int edge_num,bool isEcho = true) {
	int i,j,c1,c2;
	bool res;
	c1 = getConnectedNum();
	// kruskal 的第一个分量是一个边 因此循环次数至多是边数
	for(i=0; i<edge_num; i++) {
		res = kruskal();

		if(ECHO_KRU_RES_MX) {
			echo();
		}

		if(res == false) {//找不到边了 跳出
			break;
		}
	}

	//这时候  剩下的路权值为1的位置大概率就是桥了

	int num = 0;
	for(i=0; i<node_num-1; i++) {
		for(j=i+1; j<node_num; j++) { //对称
			if(map_mx[i][j]==1) {
				//假设是桥 置位-1
				map_mx[i][j] = -1;
				map_mx[j][i] = -1;
				c2 = getConnectedNum();
//				cout<<"c2:"<<c2<<endl;
				if(c2!=c1) {//找到桥
					num++;

					if(isEcho) {//输出
						cout<<"bridge["<<num<<"]:";
						cout<<i<<" "<<j<<endl;
					}
				}
				//之后还原
				map_mx[i][j] = 1;
				map_mx[j][i] = 1;

			}
		}
	}


	if(num==0 && isEcho) {
		cout<<"no bridge"<<endl;
	}

	return num;
}



void Map::init(int vnum,int **mx) {

	int i,j,c1,c2;

	node_num = vnum;
//矩阵默认全置位0
	for(i=0; i<MAX; i++)
		for(j=0; j<MAX; j++)
			map_mx[i][j]=0;

	for(i=0; i<node_num; i++) { //填入矩阵的数据
		visit[i]=false;//初始化自己的变量
		for(j=0; j<node_num; j++) {
			map_mx[i][j]=mx[i][j];
		}
	}
}

int main() {
	int i,j,n,e,v1,v2,num1,num2;
	int t = TEST_MAP_NUM;
	int **mx;
	Map* map;
	ofstream ofile(FILE_PATH,ios::ate);     //作为输出文件打开
	ofile<<"id  ";
	ofile<<"v-num  ";
	ofile<<"e-num  ";
	ofile<<"found  ";
	ofile<<"removeEach  ";
	ofile<<"setCircle  "<<endl;
//win:
//	DWORD time_start, time_end,time,sum1,sum2;
//mac:
	clock_t time_start, time_end,time,sum1,sum2;
	bool isEcho;
	while(t--) {

//	cin>>n>>e;//输入节点数与边数
		n = getRand(50,MAX);//
//		n = 100;

		//	e = getRand(1,EDGE_MUL*n);
		e = 300;

		if(ECHO_CREATE_MAP) {
			cout<<endl;
			cout<<"Test demo ["<<TEST_MAP_NUM-t<<"], create map,n = "<<n;
			cout<<", e = "<<e<<endl;
		}


		mx = new int*[n]; //初始化矩阵
		for(i=0; i<n; i++) {
			mx[i] = new int[n]();
			for(j=0; j<n; j++) {
				mx[i][j]=0;
			}
		}

		for(i=0; i<e; i++) { //记录连接点

			//cin>>v1>>v2;
			v1 = getRand(0,n-1);
			v2 = getRand(0,n-1);

			mx[v1][v2] = 1;
			mx[v2][v1] = 1;
		}

		map = new Map();
		map->init(n,mx);

		if(ECHO_BRIDGE_RES) {//
			cout<<"bridge-result:"<<endl;
			cout<<endl;
		}

		for(i=0,isEcho = ECHO_BRIDGE_RES,sum1=0; i<TEST_TIMES; i++) {
//			Sleep(SLEEP_TIME);

			if(i>0&&ECHO_BRIDGE_RES) { //i= 0 的时候只输出一次就好了
				isEcho = false;
			}
			//win:
//			time_start = GetTickCount();
			//mac:
			time_start = clock();
			num1 = map->removeEach(isEcho);
			time_end = clock();
			time = time_end - time_start;
			sum1 += time;

			if(ECHO_EACH_EXC_TIME)  cout << "removeEach Time = " << time << "ms"<<endl;
		}

		cout<<endl;

		if(ECHO_BRIDGE_RES) {
			cout<<"bridge-result:"<<endl;
			cout<<endl;
		}

		for(i=0,isEcho = ECHO_BRIDGE_RES,sum2=0; i<TEST_TIMES; i++) {
//			Sleep(SLEEP_TIME);

			if(i>0 && ECHO_BRIDGE_RES) { //i= 0 的时候只输出一次就好了
				isEcho = false;
			}

			//win:
//			time_start = GetTickCount();
			//mac:
			time_start = clock();
			num2 = map->setCircle(e,isEcho);
			time_end = clock();
			time = time_end - time_start;
			sum2 += time;
			if(ECHO_EACH_EXC_TIME)	cout << "setCircle Time = " << time << "ms"<<endl;

		}

		cout<<setiosflags(ios::fixed)<<setprecision(2);
		cout<<endl;
		cout << "removeEach run "<<TEST_TIMES <<" times,";
		cout << "found bridge num: "<<num1<<endl;
		cout << "total time:"<<sum1<<" ms. ";
		cout << "avg time:"<<(double)sum1/TEST_TIMES<<" ms."<<endl;

		cout<<endl;

		cout << "setCircle run "<<TEST_TIMES <<" times,";
		cout << "found bridge num: "<<num2<<endl;
		cout << "total time:"<<sum2<<" ms. ";
		cout << "avg time:"<<(double)sum2/TEST_TIMES<<" ms."<<endl;

		cout<<endl;


		ofile<<setw(1)<<t;
		ofile<<setw(10)<<n;
		ofile<<setw(10)<<e;
		ofile<<setw(10)<<num2;
		double t = (double)sum1/TEST_TIMES;
		ofile<<setw(12)<<t<<" ms";
		t = (double)sum2/TEST_TIMES;
		ofile<<setw(12)<<t<<" ms"<<endl;

		delete [] map;
		delete [] mx;
	}//while

	ofile.close();
	return 0 ;
}

