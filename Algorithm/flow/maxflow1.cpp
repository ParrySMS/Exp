#include <iostream>
#include <queue>
#include <ctime>
#include <stdio.h>
#include <stdlib.h>
#include <fstream>
#include <time.h>
#include <iomanip>

using namespace std;

const bool ECHO_MAP = true;//输出最开始的邻接矩阵
const bool ECHO_ADDED_FLOW = true;//输出每次加载的流量
const bool ECHO_MAX_FLOW = true;//输出最大流
const int TEST_TIMES = 10;
const int NULL_NODE = -1;
const int SOURCE_NODE = -2;
const int MAX = 500;
const int MAX_C = 50;
const int MAX_E = 2000;

//简单的节点对象做数据结构
class Node {
	public:
		int pre ;//前节点
		int flow  ;//流量
		bool is_back ;//是否反边

		void init() {
			pre = NULL_NODE;//前节点
			flow = 0 ;//流量
			is_back = false;//是否反边
		}
};


void getRandMap(int mx_c[][MAX],int n,int e) ;//产生一个随机的图
void initMxFlow(int mx[][MAX],int n) ;//初始化流矩阵
void echoMx(int mx[][MAX],int x,int y) ;//输出一个矩阵
void initNode(Node node[MAX],int n);//初始化节点对象数组
inline int getRand(int a ,int b) {//产生区间[a,b]上的随机数
	return (int) ( ((double)rand()/RAND_MAX)*(b-a) + a);
};

//产生一个随机的图
void getRandMap(int mx[][MAX],int n,int e) {
	int i,j,n1,n2;
	int end_num = 2;
//	srand((int)clock());

	//init 0
	for(i=0; i<n; i++) {
		for(j=0; j<n; j++) {
			mx[i][j] = 0;
		}
	}

	//filled rand
	for(i=0; i<e-end_num; i++) {
		n1 = getRand(0,n-2);
		n2 = getRand(0,n-2);
		mx[n1][n2] = getRand(0,50);
	}

	//end-flow
	for(i=0; i<end_num; i++) {
		n1 = getRand(1+(n/2),n-2);
		mx[n1][n-1] = getRand(0,MAX_C);
	}

}

//初始化流矩阵
void initMxFlow(int mx[][MAX],int n) {
	int i,j;
	for(i=0; i<n; i++) {
		for(j=0; j<n; j++) {
			mx[i][j] = 0;
		}
	}
}

//输出一个矩阵
void echoMx(int mx[][MAX],int x,int y) {
	int i,j;
	for(i=0; i<x; i++) {
		for(j=0; j<y; j++) {
			cout<<mx[i][j]<<" ";
		}
		cout<<endl;
	}
}

void initNode(Node node[MAX],int n) {
	int i;
	for(i=0; i<n; i++) {
		node[i].init();
	}

}

int main() {
	int i,j,k,node_num,edge_num,head,remaining;

	clock_t time_start, time_end,time,time_sum = 0;
	int mx_c[MAX][MAX];//容量矩阵 即邻接矩阵
	int mx_f[MAX][MAX];//流网络矩阵

	cin>>node_num>>edge_num;
//	node_num = 1965207;
//	edge_num = 5533214;

	int v1,v2,c;
	for(i=0; i<edge_num; i++) { //记录连接点与容量
		cin>>v1>>v2>>c;
		mx_c[v1][v2] = c;
	}


	for(k=0; k<TEST_TIMES; k++) {
		//初始化图
//		getRandMap(mx_c,node_num,edge_num);
		//初始化流矩阵
		initMxFlow(mx_f,node_num);

		if(ECHO_MAP) {
			echoMx(mx_c,node_num,node_num);
		}

		int min_flow = MAX;//初始化最小流
		Node node[MAX]; //节点对象数组
		initNode(node,node_num);
		node[0].pre = SOURCE_NODE;//原点
		queue<int> q;//找路径的队列
		q.push(0);//原点开始

		time_start = clock();
		while(!q.empty()) {//找最大流
			//取一个队首出队 分别计算正边反边
			head = q.front();
			q.pop();

			//正边 前向边
			for(j=0; j<node_num; j++) {
				//无路径和已标记的不管
				if(mx_c[head][j] == 0 || node[j].pre != NULL_NODE) {
					continue;
				}

				//相邻且未标记
				remaining = mx_c[head][j] - mx_f[head][j];//计算残余流量
				if(remaining>0) {
					min_flow = remaining < min_flow ? remaining:min_flow;
					//入流
					node[j].flow = min_flow;
					node[j].pre = head;
					q.push(j);
				}
			}

			//反边
			for(i=0; i<node_num; i++) {
				if(mx_c[i][head] == 0 || node[i].pre != NULL_NODE ) {
					continue;
				}

				//指向且未标记
				if(mx_f[i][head]>0) {//有流量流入 标记反边
					min_flow = mx_f[i][head] < min_flow ? mx_f[i][head]:min_flow;
					//标记
					node[i].flow = min_flow;
					node[i].pre = head;
					node[i].is_back = true;
					q.push(i);
				}
			}

			//end
			if(node[node_num-1].pre > 0) { //最后的汇点已经被标记 找到一个 进行加载
				//记录路径
				int * path = new int [node_num];
				int pre;

				for(j = node_num-1,i=0; node[j].pre != SOURCE_NODE; i++,j=pre) { //从后往前 还没到头
					path[i] = j;
					pre = node[j].pre;//往前走
					if(node[j].is_back) { //反边
						mx_f[j][pre] -= min_flow; //原指向边减去

					} else { //正边
						mx_f[pre][j] += min_flow; //正向加上
					}
				}

				if(ECHO_ADDED_FLOW) { //输出这次分配的流量
					for(j=i-1; j>=0; j--) {
						if(j) cout<<path[j]+1<<"-->";
						else  cout<<path[j]+1<<"  ";
					}
					cout<<"flow:"<<min_flow<<endl;
				}

				//reset
				min_flow = MAX;
				initNode(node,node_num);
				//clear queue
				while(q.front()!=0)
					q.pop();
				q.push(0);//原点开始
				node[0].pre = SOURCE_NODE;//原点

			}
		}//end while
		while(!q.empty())
			q.pop();
		time_end = clock();
		if(ECHO_MAX_FLOW && k==0) {
			int max_flow = 0;
			for(i=0; i<node_num; i++) {
				max_flow += mx_f[0][i];
			}
			cout<<"max_flow:"<<max_flow<<endl;
		}

		time = time_end - time_start;
		time_sum += time;
		cout<<"time:"<<time<<" ms"<<endl;
	}
	cout<<setiosflags(ios::fixed)<<setprecision(2);
	cout<<"avg-time:"<<(double)time_sum/TEST_TIMES<<" ms"<<endl;



	return 0;
}
