#include<iostream>
using namespace std;
#define ok 0
#define error -1
class ListNode {
	public:
		int data;
		ListNode *next;
		ListNode() {
			next = NULL;
		}
};

class LinkList {
	public:
		ListNode *head;
		int len;
		LinkList();
		~LinkList();
		ListNode * last_index(int i);//返回第i-1节点指针
		int get(int i);//获取元素
		int insert(int i ,int item);//插入第i位
		int del(int i);
		void show(int res);

};

LinkList::LinkList() {
	head = new ListNode();
	len = 0;
}


LinkList::~LinkList() {
	ListNode *p,*q;
	p = head;
	while(p!=NULL) {
		q=p;
		p=p->next;
		delete q;
	}
	len = 0;
	head = NULL;
}

//返回第i-1节点指针
ListNode * LinkList::last_index(int i) {
	int index;
	ListNode *p;
	p = head;

	for(index=1; index<i; index++) {
		p=p->next;
	}
	return (p)?p:NULL;
}


void LinkList::show(int res) {
	if(res == error) {
		cout << "error";
	} else {

		ListNode *p;
		p = head->next;
		while(p!=NULL) {
//			cout << "p:"<< p <<endl;
			cout<< p->data << ' ';
			p=p->next;
		}
	}
	cout<<endl;
}

//插入
int LinkList::insert(int i ,int item) {
	ListNode *p,*q;
	if(i<=0) {
		return error;
	}else {
		q = new ListNode();
		
		p = last_index(i); //上一节点 
		
		q->next = p->next;
		q->data = item; 
		p->next = q;
		len++;
	}

	return ok;
}

int del(int i){
	
}




int main() {
	int num,i,index,data,res;
	LinkList sll;
	//init insert
	scanf("%d ",&num);
	for(i=1; i<num+1; i++) {
		scanf("%d",&data);
		res = sll.insert(i,data);
	}
	sll.show(res);
	

	//normal insert
	for(i=0; i<2; i++) {
		scanf("%d %d",&index,&data);
		res = sll.insert(index,data);
		sll.show(res);
	}

	//todo 
	//delete
	for(i=0; i<2; i++) {
		scanf("%d",&index);
		res = sll.del(index);
		sll.show(res);
	}

	//search
	for(i=0; i<2; i++) {
		scanf("%d",&index);
		data = sq.list_get(index);
		if(data!=error) {
			cout << data << endl;
		}
	}
	
	
	
	
	
	sll.~LinkList();
	return 0;
}

